<?php

namespace ReservationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use Symfony\Component\HttpFoundation\Request;

use ReservationBundle\Entity\Reservation;
use ReservationBundle\Entity\Salle;
use ReservationBundle\Form\SalleType;
use ReservationBundle\Form\ReservationType;

class DefaultController extends Controller
{
    /**
     * @Route("/home", name="reservationbundle_index")
     * @Template()
     */
    public function indexAction()
    {
		/*$em = $this->getDoctrine()->getManager();*/
		
		$salle1 = new Salle();
		$salle1->setNom('Salle1');
		$salle2 = new Salle();
		$salle2->setNom('Salle2');
		
		$resa = new Reservation();
		$resa->setNom('Reservation1');
		$resa->setSalle($salle1);
		
		/*$em->persist($salle1);
		$em->persist($salle2);
		$em->persist($resa);
		
		$em->flush();*/
		
        return array(
				'ma_reservation' => $resa,
		);
    }
    
    /**
     * @Route("/salles", name="reservationbundle_salles")
     * @Template()
     */
    public function sallesAction()
    {		
		$em = $this->getDoctrine()->getManager();
		$repoSalles = $em->getRepository('ReservationBundle:Salle');
		
		$salles = $repoSalles->findall();

        return array(
			'les_salles' => $salles,
		);
    }
    
    /**
     * @Route("/salles/{id}", name="reservationbundle_voir", requirements={"id"="\d+"})
     * @Template()
     */
    public function voirAction($id)
    {		
		$em = $this->getDoctrine()->getManager();
		$repoSalles = $em->getRepository('ReservationBundle:Salle');
		
		$salle = $repoSalles->findOneById($id);
		dump($salle);

		if(!$salle) {
			throw $this->createNotFoundException('La salle avec l\'id '.$id.' n\'existe pas...');
		}
		
        return array(
			'la_salle' => $salle,
		);
    }
    
    /**
     * @Route("/reservations", name="reservationbundle_reservations")
     * @Template()
     */
    public function reservationsAction()
    {		
        $em = $this->getDoctrine()->getManager();
		$repoResas = $em->getRepository('ReservationBundle:Reservation');
		
		$resas = $repoResas->findall();

        return array(
			'les_resas' => $resas,
		);
    }
    
    /**
     * @Route("/reserver", name="reservationbundle_reserver")
     * @Template()
     */
    public function reserverAction(Request $request)
    {		
		
		$reservation = new Reservation();	
		
		$form = $this->createForm(
			new ReservationType(),
			$reservation,
			array(
				'action' => $this->generateUrl('reservationbundle_reserverOk')
			)
		);
							
        return array(
			'formulaire_reservation' => $form->createView()
		);
    }
    
    /**
     * @Route("/salles/ajouter", name="reservationbundle_ajouter")
     * @Template()
     */
    public function ajouterAction(Request $request)
    {		
		
		$salle = new Salle();	
		
		$form = $this->createForm(
			new SalleType(),
			$salle,
			array()
		);
		
		$form->handleRequest($request);
		
		if($form->isValid())
		{
			$em = $this->getDoctrine()->getManager();
			$em->persist($salle);
			$em->flush();
			
			return $this->redirect($this->generateUrl('reservationbundle_salles'));
		}
					
        return array(
			'formulaire_salle' => $form->createView()
		);
    }
    
    /**
     * 
     * @Route("/reserver/OK", name="reservationbundle_reserverOk")
     * @Template() 
     * @Method("post")
     */
     
     public function okAction(Request $request)
     {
		 $reservation = new Reservation();	
		
		$form = $this->createForm(
			new ReservationType(),
			$reservation,
			array()
		);
		
		$form->handleRequest($request);
		
		if($form->isValid())
		{
			$em = $this->getDoctrine()->getManager();
			$em->persist($reservation);
			$em->flush();
			
		}
					
        return array();
	 }
}
