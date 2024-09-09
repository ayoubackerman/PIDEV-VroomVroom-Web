<?php

namespace App\Controller;

use App\Entity\Reservation;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelLow;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Label\Label;
use Doctrine\Persistence\ManagerRegistry;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Label\Font\NotoSans;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
class QrCodeController extends AbstractController
{
    #[Route('/qr-codes/{idReservation}', name: 'app_qr_codes', methods: ['GET'])]
public function index(int $idReservation,UrlGeneratorInterface $urlGenerator): Response
{
    $writer = new PngWriter();
    
    // Get the event data from the database using the ID parameter
    $Reservation = $this->getDoctrine()->getRepository(Reservation::class)->find($idReservation);

    // Create the QR code with the event data
    $qrCode = QrCode::create(
        sprintf(
            "ID Réservation: %d\nID Trajet: %s\nID Utilisateur: %s\nURL de Réservation: %s",
            $Reservation->getIdReservation(), // utiliser getIdReservation() pour obtenir l'ID de la réservation
            $Reservation->getIdTrajet(),
            $Reservation->getIdUser(),
            $reservationUrl = $urlGenerator->generate('app_reservation_new', ['id' => $Reservation->getIdReservation()], UrlGeneratorInterface::ABSOLUTE_URL)
            )
        )->setEncoding(new Encoding('UTF-8'))
         ->setErrorCorrectionLevel(new ErrorCorrectionLevelLow())
         ->setSize(120)
         ->setMargin(0)
     ->setForegroundColor(new Color(0, 0, 0))
     ->setBackgroundColor(new Color(255, 255, 255));
    
    // Add logo and label to the QR code
    $logo = Logo::create('img.jpg')->setResizeToWidth(60);
    $label = Label::create('')->setFont(new NotoSans(8));
 
    // Generate QR codes with different styles
    $qrCodes = [];
    $qrCodes['img'] = $writer->write($qrCode, $logo)->getDataUri();
    $qrCodes['simple'] = $writer->write($qrCode, null, $label->setText('Simple'))->getDataUri();
    $qrCode->setForegroundColor(new Color(255, 0, 0));
    $qrCodes['changeColor'] = $writer->write($qrCode, null, $label->setText('Color Change'))->getDataUri();
    $qrCode->setForegroundColor(new Color(0, 0, 0))->setBackgroundColor(new Color(255, 0, 0));
    $qrCodes['changeBgColor'] = $writer->write($qrCode, null, $label->setText('Background Color Change'))->getDataUri();
    $qrCode->setSize(200)->setForegroundColor(new Color(0, 0, 0))->setBackgroundColor(new Color(255, 255, 255));
    $qrCodes['withImage'] = $writer->write($qrCode, $logo, $label->setText('With Image')->setFont(new NotoSans(20)))->getDataUri();
    $reservationUrl = $urlGenerator->generate('app_reservation_new', ['id' => $Reservation->getIdReservation()]);
    return $this->render('qr_code/index.html.twig', array_merge($qrCodes,['reservationUrl' => $reservationUrl]));

}

}