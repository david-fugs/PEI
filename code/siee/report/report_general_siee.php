<?php
	
	require_once('../../../fpdf/fpdf.php');

	include("global.php");

	$id_cole	= $_POST['id_cole'];
	
	// Obtiene la fecha actual 
		
	class PDF extends FPDF
	{
		
		// Se heredan todas las funciones para hacer el Encabezado de la página
		function Header()
		{
			// Logo
			$this->Image('../../../img/logo_educacion.png',5 ,5, 100 , 25);
			// Arial bold 15
			$this->SetFont('Arial','B',11);
			// Movernos a la derecha (espacio)
			$this->Cell(20);
			// Título (PROPIEDAD DESPUÉS DEL TITULO ES CONTORNO, SALTO DE LÍNEA, ALINEACIÓN)
			$this->Cell(170,4,'SISTEMA INSTITUCIONAL DE EVALUACION',0,1,'R');
			$this->Cell(175,8,'DE LOS ESTUDIANTES -SIEE-',0,0,'R');
			$this->Cell(20,20,'http://sed2.risaralda.gov.co/CalidadEducativa/PEI',0,0,'R');
			// Salto de línea
			$this->Ln(25);
		}
		
		// Se crea la función FOOTER "Pie de página"
		function Footer()
		{
			date_default_timezone_set("America/Bogota");
			// Posición: a 1,5 cm del final
			$this->SetY(-15);
			// Arial italic 8
			$this->SetFont('Arial','B',7);
			// Número de página
			$this->Cell(0,10,'FECHA Y HORA DE IMPRESION: '.$fecha=date("Y-m-d H:i:s"),0,0,'C');
			$this->Ln(3);
			$this->SetFont('Arial','I',7);
			$this->Cell(0,10,'Numero total de paginas '.$this->PageNo().'/{nb}',0,0,'C');	
		}

		function VariasLineas($cadena, $cantidad)
		{
			$this->Cell(100,0,'','B');
				while (!(strlen($cadena)==''))
				{
				    $subcadena = substr($cadena, 0, $cantidad);
				    $this->Ln();
				    $this->Cell(100,5,$subcadena,'LR',0,'L');
				    $cadena= substr($cadena,$cantidad);
				}
			$this->Cell(100,0,'','T');
		}  

	}

	$consulta = "SELECT * FROM `siee` WHERE id_cole='$id_cole' ";
	$res = mysqli_query($conexion,$consulta);
	$num_reg = mysqli_num_rows($res);
	$pdf = new PDF('P','mm','Letter');
	$pdf->AliasNbPages();
	$pdf->Addpage();
	if ($num_reg>0) 	{  
		//Limpiar (eliminar) y deshabilitar los búferes de salida.
		//ob_end_clean();
		
		$pdf->SetAuthor('Ing. Eumir Pulido de la Pava');
		$pdf->SetCreator('Ing. Eumir Pulido de la Pava');
		$pdf->SetTitle('GOBERNACION RISARALDA v1.0');

		$pdf->SetFillColor(30,179,75);
		$pdf->SetFont('Arial','B',13);
		$pdf->SetX(10);
		//$pdf->Cell(80,8,'PLACA CONSULTADA: '.$placa,1,1,'C',1);
		$pdf->SetFillColor(232,232,232);
		$pdf->SetFont('Arial','B',9);
		$pdf->MultiCell(7,6,'1. ¿Tiene definido el sistema institucional de evaluación de los estudiantes en su establecimiento educativo?',1,'C',1);
		$pdf->Ln(-12);
		$pdf->SetX(17);

		
		$i=1;
		$k=1;
		while($i<=$num_reg)
		{
			$f= mysqli_fetch_array($res);
			$pdf->SetX(4);
			$pdf->Cell(6,6,$k,1,0,'C');
			$pdf->SetFont('Arial','',7);
			$pdf->SetX(10);
			$pdf->Cell(7,6,$f['preg1_siee'],1,0,'C');
			$pdf->SetX(17);
		
			$i++;

			if ($k==24)
			{
				$pdf->AliasNbPages();
				$pdf->Addpage();

				$pdf->SetFillColor(30,179,75);
				$pdf->SetFont('Arial','B',13);
				$pdf->SetX(10);
				//$pdf->Cell(80,8,'PLACA CONSULTADA: '.$placa,1,1,'C',1);
				$pdf->SetFillColor(232,232,232);
				$pdf->SetFont('Arial','B',9);
				$pdf->MultiCell(7,6,'1. ¿Tiene definido el sistema institucional de evaluación de los estudiantes en su establecimiento educativo?',1,'C',1);
				$pdf->Ln(-12);
				$pdf->SetX(17);
				$k=0;
			}
		$k=$k+1;
		
		}
		
	}

	else {

		$pdf->SetFillColor(232,232,232);
		$pdf->SetFont('Arial','B',13);
		$pdf->SetX(10);
		//$pdf->Cell(260,8,'NO HAY INFRACCIONES RELACIONADAS A ESTE NUMERO DE PLACA: '.$placa,1,1,'C',1);
		$pdf->Ln(25);
		$pdf->SetFont('Arial','B',12);
		$pdf->Cell(0,10,'LA ANTERIOR INFORMACION SE BRINDA SIN PERJUICIO DE LAS ACTUALIZACIONES QUE',0,1,'C');
		$pdf->Cell(0,10,'SE REALIZAN CONSTANTEMENTE EN LAS BASES DE DATOS DE LA ENTIDAD',0,0,'C');

	}

	$pdf->Output();
?>