<?php
    class Constantes {
        //Constantes de segmentos
        public $SEGMENTOS = array();

        //Constate de codumento de identidad
        public $DOCUMENTO_IDENTIDAD = array();

        //Constate de tipo de cotización
        public $TIPO_COTIZACION = array();

        // Estado para peticiones
        public $ESTADO_PETICION = array();

        //METODOS_PAGOS
        public $METODO_PAGO = array();

        //TURNOS
        public $TURNOS = array();
        //tipo Moneda
        public $TIPO_MONEDA = array();

        //TIPO DE GASTOS
        public $TIPO_GASTOS = array();

        //Dias dias semana
        public $DIAS_SEMANA = array();

        //Constantes para meses
        public $MESES = array();


        public function __construct() {
            //Constante de segmentos
            $this->SEGMENTOS = array(
                1 => 'Pública',
                2 => 'Privada'
            );

            //Documento identidad
            $this->DOCUMENTO_IDENTIDAD = array(
                6 =>'RUC',
                1 =>'DNI',
            );

			//Documento identidad
			$this->DOCUMENTO_IDENTIDAD_TRANSPORTISTA = array(
				1 =>'DNI',
				4 =>'CARNET DE EXTRANJERIA',
				7 =>'PASAPORTE',
			);

            //Constante tipo cotización
            $this->TIPO_COTIZACION = array(
                1 => 'Productos',
                2 => 'Servicios'
            );

            $this->ESTADO_PETICION = array(
                -1 => 'Pendiente',
                1  => 'Aceptada',
                2  => 'Rechazado',
            );

            //METODOS pagos
            $this->METODO_PAGO = array(
                    1  => 'Efectivo',
                    2  => 'Consignación',
                    3  => 'Transferencia',
                    4  => 'Cheque',
                    5  => 'Tarjeta de crédito',
                    6  => 'Tarjeta de débito',
            );

            //tipo Moneda
            $this->TIPO_MONEDA = array(
                1 => 'Soles',
                2 => 'Dolares',
            );

            //TURNOS
            $this->TURNOS = array(
                1 => 'AM',
                2 => 'PM'
            );

            //Tipo gastos
            $this->TIPO_GASTOS = array(
                1 => 'Forrajes',
                2 => 'Prestamo Asociación',
                3 => 'Maquina de Ordeño',
                4 => 'Deuda Asociación',
                5 => 'Proveedor Agrop La Villa',
                6 => 'Proveedor Senasa',
                7 => 'Proveedor Lobitos',
                8 => 'Cascar de Maracuyad',
                9 => 'Panca Molida',
                10 => 'Orujo',
                11 => 'Helados, Yogur y Queso',
                12 => 'Otros',
            );

            //DIAS SEMANA
            $this->DIAS_SEMANA = array(
                1 => 'Lunes',
                2 => 'Martes',
                3 => 'Miércoles',
                4 => 'Juéves',
                5 => 'Viernes',
                6 => 'Sábado',
                7 => 'Domingo',
            );
            
            //Constantes para meses
            $this->MESES = array(
                1 => 'Enero',
                2 => 'Febrero',
                3 => 'Marzo',
                4 => 'Abril',
                5 => 'Mayo',
                6 => 'Junio',
                7 => 'Julio',
                8 => 'Agosto',
                9 => 'Septiembre',
                10 => 'Octubre',
                11 => 'Noviembre',
                12 => 'Diciembre',
            );
        }//end __construct



    }//end Class Constantes

?>
