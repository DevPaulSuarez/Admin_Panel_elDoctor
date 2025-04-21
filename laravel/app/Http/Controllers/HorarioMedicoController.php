<?php

namespace App\Http\Controllers;

use App\Models\Especialidad;
use App\Models\Horario;
use App\Models\HorarioEspecialidad;
use App\Models\LugarAtencion;
use App\Models\Medico;
use App\Models\Parametro;
use App\Models\Reservacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use stdClass;

class HorarioMedicoController extends Controller
{
    public function index()
    {
        if (!session()->has('current_user')) {
            return redirect()->intended('/login');
        }
        $especialidades = Especialidad::orderBy('name', 'asc')->get();
        return view('horario-medico.index')->with('categorias', $especialidades);
    }

    public function store(Request $request)
    {
        $horarios = Horario::where('fecha', $request->fecha)->where('idmedic', $request->medico_id)->get();

        $existe = $this->existeFecha($horarios, $request->horainicio . ':00', $request->horafin . ':00');
        if (count($existe) > 0) {
            return false;
        } else {
            $horario = new Horario;
            $horario->idmedic = $request->medico_id;
            $horario->fecha = $request->fecha;
            $horario->horainicio = $request->horainicio . ':00';
            $horario->horafin = $request->horafin . ':00';
            $horario->idlugaratencion = $request->lugar;
            $horario->id_clinica = session('current_user')->id;
            $horario->save();

            if ($request->especialidad != null) {
                $especialidades = $request->especialidad;
                foreach ($especialidades as $especialidad) {
                    $horarioEspecialidad = new  HorarioEspecialidad;
                    $horarioEspecialidad->medico_id = $request->medico_id;
                    $horarioEspecialidad->horario_id = $horario->id;
                    $horarioEspecialidad->especialidad_id = $especialidad;
                    $horarioEspecialidad->save();
                }
            }
            return true;
        }
    }

    public function update($id, Request $request)
    {
        $horario = Horario::find($id);
        $horarios = Horario::where('fecha', $horario->fecha)->where('idmedic', $horario->idmedic)->get();
        $newHorarios = [];
        foreach ($horarios as $hor) {
            if($hor->id != $id) {
                array_push($newHorarios, $hor);
            }
        }
        $horaInicio = strlen($request->horainicio) == 5 ? $request->horainicio.':00' : $request->horainicio;
        $horaFin = strlen($request->horafin) == 5 ? $request->horafin.':00' : $request->horafin;
        $existe = $this->existeFecha($newHorarios, $horaInicio, $horaFin);

        if (count($existe) > 0) {
            return false;
        } else {
            $horario->horainicio = $horaInicio;
            $horario->horafin = $horaFin;
            $horario->idlugaratencion = $request->lugar;
            $horario->save();

            $especialidades = $request->especialidad;
            $horarioEspecialidades = HorarioEspecialidad::where('horario_id', $id)->get();
            foreach ($especialidades as $especialidad) {
                $existe = false;
                foreach ($horarioEspecialidades as $horarioEspecialidad) {
                    if ($especialidad == $horarioEspecialidad->especialidad_id) {
                        $existe = true;
                        break;
                    }
                }

                if (!$existe) {
                    $horarioEspecialidad = new HorarioEspecialidad;
                    $horarioEspecialidad->medico_id = $request->medico_id;
                    $horarioEspecialidad->horario_id = $id;
                    $horarioEspecialidad->especialidad_id = (int) $especialidad;
                    $horarioEspecialidad->save();
                }
            }

            foreach ($horarioEspecialidades as $horarioEspecialidad) {
                $existe = false;
                foreach ($especialidades as $especialidad) {
                    if ($horarioEspecialidad->especialidad_id == $especialidad) {
                        $existe = true;
                        break;
                    }
                }
                if (!$existe) {
                    $horarioEspecialidad->delete();
                }
            }
            return true;
        }
    }

    public function destroy($id)
    {
        $horario = Horario::find($id);
        HorarioEspecialidad::where('horario_id', $id)->delete();
        $horario->delete();
        return $horario;
    }

    public function getByIdMedico($medico_id)
    {
        $HorarioEEN = [];
        $HorariosEstablecido = Horario::select('horario.id', 'horario.fecha', 'horario.horainicio', 'horario.horafin', 'horario.idlugaratencion', 'horarios_especialidad.medico_id as idmedic', DB::raw('group_concat(horarios_especialidad.especialidad_id) as especialidades_id'))
            ->join('horarios_especialidad', 'horarios_especialidad.horario_id', '=', 'horario.id')
            ->join('medic', 'horarios_especialidad.medico_id', '=', 'medic.id')
            ->whereYear('horario.fecha', date('Y'))
            ->where('horario.fecha', '>=', DB::raw('curdate()'))
            ->where('id_clinica', session('current_user')->id)
            ->where('medic.id', $medico_id)
            ->groupBy('horario.id')->get();

        foreach ($HorariosEstablecido as $HEstablecido) {

            $Lugar = LugarAtencion::find($HEstablecido->idlugaratencion);
            $Doctor = Medico::find($HEstablecido->idmedic);

            $especialidades = explode(',', $HEstablecido->especialidades_id);
            $especialidadArray = [];
            foreach ($especialidades as  $especialidad) {
                $especialidadData = Especialidad::find($especialidad);
                $data = new stdClass();
                $data->id = $especialidadData->id;
                $data->name = $especialidadData->name;
                array_push($especialidadArray, $data);
            }
            $NuevoHEEvento = new stdClass();
            $NuevoHEEvento->id = $HEstablecido->id;
            $NuevoHEEvento->title = $Doctor->name . ' ' . $Doctor->lastname . "\n" . $Lugar->lugar;
            $NuevoHEEvento->start = $HEstablecido->fecha . 'T' . $HEstablecido->horainicio;
            $NuevoHEEvento->end = $HEstablecido->fecha . 'T' . $HEstablecido->horafin;
            $NuevoHEEvento->color = $Lugar->color;
            $NuevoHEEvento->iddepartamento = $Lugar->iddepartamento;
            $NuevoHEEvento->idprovincia = $Lugar->idprovincia;
            $NuevoHEEvento->idlugar = $Lugar->id;
            $NuevoHEEvento->especialidades = $especialidadArray;
            $HorarioEEN[] = $NuevoHEEvento;
        }

        return $HorarioEEN;
    }

    public function horarioMedicoEstablecido($especialidad_id, $medico_id, $year, $month, $lugar_id)
    {
        $cuposLibres = [];
        $cuposOcupados = [];

        $horarioEstablecido = Horario::select('horainicio', 'horafin', 'fecha', 'idmedic', 'lugaratencion.color')
            ->join('horarios_especialidad', 'horario.id', '=', 'horarios_especialidad.horario_id')
            ->join('lugaratencion', 'lugaratencion.id', '=', 'horario.idlugaratencion')
            ->where('horarios_especialidad.medico_id', $medico_id)
            ->where('horarios_especialidad.especialidad_id', $especialidad_id)
            ->whereYear('fecha', $year)
            ->whereMonth('fecha', $month)
            ->where('fecha', '>=', date('Y-m-d'))
            ->where('idlugaratencion', $lugar_id)->get();

        $CuposEstablecidos  = $this->extraerCuposEstablecidos($horarioEstablecido);
        $tiempoConsulta  = Parametro::where('nombre', 'TiempoConsulta')->get();
        $tiempoConsulta  = '00:' . $tiempoConsulta[0]->valor . ':00';

        $horarioOcupado = Reservacion::select('medic_id as idmedic', 'date_at as fecha', 'time_at as horainicio', DB::raw('addtime(time_at,"' . $tiempoConsulta . '") as horafin'))
            ->where('medic_id', $medico_id)
            ->whereYear('date_at', $year)
            ->whereMonth('date_at', $month)
            ->where('date_at', '>=', date('Y-m-d'))
            ->where('idlugar', $lugar_id)->get();


        $cuposOcupados  = $this->extraerCuposOcupados($horarioOcupado);
        $cuposLibres = $this->cuposLibres($CuposEstablecidos, $cuposOcupados);
        return $cuposLibres;
    }

    private function extraerCuposEstablecidos($horarioEstablecidos)
    {
        $cupos        = [];
        $numerocupo   = 1;

        foreach ($horarioEstablecidos as $horarioEstablecido) {
            $horainicio = $horarioEstablecido->horainicio;
            $horafin    = $horarioEstablecido->horafin;
            $fecha      = $horarioEstablecido->fecha;
            $cupoinicio      = $horainicio;
            $diferenciahoras = $this->restarTiempo($horainicio, $horafin);
            $cantidadCupos   = $this->cantidadCupoEstablesidos($diferenciahoras);
            $TiempoConsulta  = Parametro::where('nombre', 'TiempoConsulta')->get();
            $TiempoConsulta  = '00:' . $TiempoConsulta[0]->valor . ':00';
            for ($i = 0; $i < $cantidadCupos; $i++) {
                $cupo         = new stdClass();
                $cupo->numero = $numerocupo;
                $numerocupo++;
                $cupo->idmedic = $horarioEstablecido->idmedic;
                $cupo->fecha   = $fecha;
                $cupo->inicio  = $cupoinicio;
                $cupoinicio    = $this->sumarTiempo($cupoinicio, $TiempoConsulta);
                $cupo->fin     = $cupoinicio;
                $cupo->color   = $horarioEstablecido->color;
                $cupos[]       = $cupo;
            }
        }
        return $cupos;
    }

    private function restarTiempo($horaini, $horafin)
    {
        $horai = substr($horaini, 0, 2);
        $mini  = substr($horaini, 3, 2);
        $segi  = substr($horaini, 6, 2);
        $horaf = substr($horafin, 0, 2);
        $minf  = substr($horafin, 3, 2);
        $segf  = substr($horafin, 6, 2);
        $ini = ((($horai * 60) * 60) + ($mini * 60) + $segi);
        $fin = ((($horaf * 60) * 60) + ($minf * 60) + $segf);
        $dif = $fin - $ini;
        $difh = floor($dif / 3600);
        $difm = floor(($dif - ($difh * 3600)) / 60);
        $difs = $dif - ($difm * 60) - ($difh * 3600);
        return date("H:i:s", mktime($difh, $difm, $difs));
    }

    private function sumarTiempo($horaini, $horafin)
    {
        $horai = substr($horaini, 0, 2);
        $mini  = substr($horaini, 3, 2);
        $segi  = substr($horaini, 6, 2);
        $horaf = substr($horafin, 0, 2);
        $minf  = substr($horafin, 3, 2);
        $segf  = substr($horafin, 6, 2);
        $ini = ((($horai * 60) * 60) + ($mini * 60) + $segi);
        $fin = ((($horaf * 60) * 60) + ($minf * 60) + $segf);
        $dif = $fin + $ini;
        $difh = floor($dif / 3600);
        $difm = floor(($dif - ($difh * 3600)) / 60);
        $difs = $dif - ($difm * 60) - ($difh * 3600);
        return date("H:i:s", mktime($difh, $difm, $difs));
    }

    private function cantidadCupoEstablesidos($diferenciahoras)
    {
        $horas = substr($diferenciahoras, 0, 2);
        $minutos = substr($diferenciahoras, 3, 2);
        $segundos = substr($diferenciahoras, 6, 2);
        $tiempo = ((($horas * 60) * 60) + ($minutos * 60) + $segundos);
        $TiempoConsulta = Parametro::where('nombre', 'TiempoConsulta')->get();
        $cupos = floor($tiempo / (60 * $TiempoConsulta[0]->valor));
        return $cupos;
    }

    private function extraerCuposOcupados($horarioOcupado)
    {
        $numerocupo = 1;
        $cupoOcupados = [];
        foreach ($horarioOcupado as $HOcupado) {
            $cupo         = new stdClass();
            $cupo->numero = $numerocupo;
            $numerocupo++;
            $cupo->idmedic  = $HOcupado->idmedic;
            $cupo->fecha    = $HOcupado->fecha;
            $cupo->inicio   = $HOcupado->horainicio;
            $cupo->fin      = $HOcupado->horafin;
            array_push($cupoOcupados, $cupo);
        }
        return $cupoOcupados;
    }

    private function cuposLibres($cuposEstablecidos, $cuposOcupados)
    {
        for ($i = 0; $i < count($cuposEstablecidos); $i++) {
            for ($o = 0; $o < count($cuposOcupados); $o++) {
                if ($cuposEstablecidos[$i]->inicio == $cuposOcupados[$o]->inicio && $cuposEstablecidos[$i]->fecha === $cuposOcupados[$o]->fecha) {
                    array_splice($cuposEstablecidos, $i, 1);
                }
            }
        }
        return $cuposEstablecidos;
    }

    private function existeFecha($horarios, $hora_inicio, $hora_fin)
    {
        $existe = [];
        foreach ($horarios as $horario) {
            if ($horario->horainicio < $hora_inicio && $horario->horafin > $hora_inicio) {
                array_push($existe, $horario);
            } else if ($horario->horainicio < $hora_fin && $horario->horafin > $hora_fin) {
                array_push($existe, $horario);
            } else if ($horario->horainicio == $hora_inicio && $horario->horafin == $hora_fin) {
                array_push($existe, $horario);
            } else if ($horario->horainicio > $hora_inicio && $horario->horainicio < $hora_fin) {
                array_push($existe, $horario);
            }
        }
        return $existe;
    }
}
