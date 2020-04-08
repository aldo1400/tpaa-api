<?php

namespace App\Console\Commands;

use App\Encuesta;
use Carbon\Carbon;
use Illuminate\Console\Command;

class VerificarEstadoEncuesta extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'encuestas:estado';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verificar si los colaboradores han completado sus encuestas pendientes.';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $encuestas = Encuesta::all();
        foreach ($encuestas as $encuesta) {
            $colaboradores = $encuesta->colaboradores;
            foreach ($colaboradores as $colaborador) {
            }
        }
        // Creamos los datos de entrada
        date_default_timezone_set('UTC');
        $DataDate = Carbon::now();

        //Obtengo la fecha en formato para Encuesta Facil
        $DataDate = $DataDate->format('YmdHis');
        //$DataDate = '20191114171844';
        $encuestaID = '2583021';
        //http://www.encuestafacil.com/RespWeb/Qn.aspx?EID=2583021&ParamID=15673399-7
        //Se agregan 000 hasta completar los 9 caracteres
        if (strlen($encuestaID) == 6) {
            $encuestaIDToken = '000'.$encuestaID;
        } elseif (strlen($encuestaID) == 7) {
            $encuestaIDToken = '00'.$encuestaID;
        } elseif (strlen($encuestaID) == 8) {
            $encuestaIDToken = '0'.$encuestaID;
        }
        //Encriptacion de la clave
        $claveTPA = 'SecretoTpA';
        $token = $encuestaIDToken.$DataDate.$claveTPA;
        $token = utf8_encode($token);

        // Encripto a md5
        $sha1 = md5($token, false);
        $sha1 = strtoupper($sha1);
        $key = $sha1;
        //Array $status sirve para obtener el estado de la encuesta
        $status = array(
            'DataDate' => $DataDate,
            'Token' => $key,
            'SurveyID' => $encuestaID,
            'ParamID' => '15947587-5',
        );
        //$encuesta sirve para crear la URL de la encuesta
        $encuesta = array(
            'DataDate' => $DataDate,
            'Token' => $key,
            'SurveyID' => '2583021',
            'ParamID' => '15947587-5',
            'IDStyle' => 'x',
            'LogoHead' => 'x',
            'LogoFooter' => 'x',
        );
        //XML Respuestas
        $respuestas = array(
            'DataDate' => $DataDate,
            'Token' => $key,
            'SurveyID' => '2583021',
            'StartDate' => '',
            'EndDate' => '',
            'ParamID' => '15947587-5',
        );

        // Este es el webservice que vamos a consumir
        $wsdl = 'https://www.encuestafacil.com/masinfo/sinfocuest/WSinfocuest.asmx?WSDL';

        // Creamos el cliente SOAP que hará la solicitud, generalmente están
        // protegidos por un usuario y una contraseña
        $opts = array(
             'ssl' => array(
               'verify_peer' => false,
               'verify_peer_name' => false,
               'allow_self_signed' => true,
            ),
        );
        $context = stream_context_create($opts);

        $cliente = new \SoapClient($wsdl, [
                'stream_context' => $context,
                'trace' => true,
                'DataDate' => $DataDate,
                'Token' => $key,
            ]);
        //Obtener todas las funciones de la API
        //dd($cliente->__getFunctions());
        $params = array('DataDate' => $DataDate, 'Token' => $key, 'SurveyID' => $encuestaID, 'ParamID' => '156733997');

        //dd($cliente->QuestStatus($params));
        $cliente->__soapCall('QuestStatus', array($params));
        //dd($cliente);
        // Consumimos el servicio llamando al método que necesitamos, en este caso
        //$resultado = $cliente->XMLQuest($respuestas);
        //Retorna estado de la encuesta
        $resultado = $cliente->QuestStatus($status);
        //Crea la URL
        //$resultado = $cliente->URLCoded($encuesta);
        //Encuesta respuestas (Entrega un html con la tabla y sus respuestas)
        //$resultado = $cliente->QuestResponse($status);
        //Método para enviar email
        //Entrega -1 General error, puede ser porque estamos en ambiente de prueba
        //	$resultado = $cliente->SendEMail($mail);

        // Finalmente muestras la respuesta
        //dd($resultado);
        //Convertir a array()

        $json = json_encode($resultado);
        $resultado = json_decode($json, true);
        dd($json);
        //dd($array);
        //dd($array['URLCodedResult']['Result']);
        //$result = json_encode($resultado);
        //dd($result->Result);
    }
}
