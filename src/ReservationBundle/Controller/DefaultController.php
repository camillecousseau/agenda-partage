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
use ReservationBundle\Form\resaSalleType;

class DefaultController extends Controller
{
	
	// Index
    /**
     * @Route("/home", name="reservationbundle_index")
     * @Template()
     */
    public function indexAction()
    {
		$em = $this->getDoctrine()->getManager();
		
		$repoResas = $em->getRepository('ReservationBundle:Reservation');
		
		$events = $repoResas->findall();
		
        return array(
				'events' => $events,
		);
    }
    
    
    // Vue SALLES
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
    
    
    // Vue SALLE choisie
    /**
     * @Route("/salles/{id}", name="reservationbundle_voir", requirements={"id"="\d+"})
     * @Template()
     */
    public function voirAction($id)
    {		
		$em = $this->getDoctrine()->getManager();
		$repoSalles = $em->getRepository('ReservationBundle:Salle');
		
		$salle = $repoSalles->findOneById($id);

		if(!$salle) {
			throw $this->createNotFoundException('La salle avec l\'id '.$id.' n\'existe pas...');
		}
		
        return array(
			'la_salle' => $salle,
		);
    }
    
    
    // Formulaire AJOUTER salle
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
		
		$form->add('submit', 'submit', array('label' => 'Ajouter'));
		
		$form->handleRequest($request);
		
		if($form->isValid())
		{
			$em = $this->getDoctrine()->getManager();
			
			$salle->getImage()->upload();
			
			$em->persist($salle);
			$em->flush();
			
			return $this->redirect($this->generateUrl('reservationbundle_salles'));
		}
					
        return array(
			'formulaire_salle' => $form->createView()
		);
    }
    
    
    // SUPPRESSION salle
    /**
     * @Route("/salles/suppression/{id}", name="reservationbundle_supprimer", requirements={"id"="\d+"})
     * @Template()
     */
    public function supprimerAction($id)
    {		
		$em = $this->getDoctrine()->getManager();
		$repoSalles = $em->getRepository('ReservationBundle:Salle');
		
		$salle = $repoSalles->findOneById($id);

		if(!$salle) {
			throw $this->createNotFoundException('La salle avec l\'id '.$id.' n\'existe pas...');
		}
		
        $em->remove($salle);
        $em->flush();

        return $this->redirect($this->generateUrl('reservationbundle_salles'));
    }
    
    
    /**
    * Creates a form to edit a Salle entity.
    *
    * @param Salle $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Salle $entity)
    {
        $form = $this->createForm(new SalleType(), $entity, array(
            'action' => $this->generateUrl('reservationbundle_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Modifier'));

        return $form;
    }
    
    
    //  MAJ Salle
    /**
     * @Route("/{id}", name="reservationbundle_update")
     * @Method("PUT")
     * @Template("ReservationBundle:Salle:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ReservationBundle:Salle')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Salle entity.');
        }

        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);
        
        if($editForm->isValid()) {
			
			$entity->getImage()->upload();
			$em->flush();
			
			return $this->redirect($this->generateUrl('reservationbundle_edit', array('id' => $id)));
		}

        return array(
            'salle'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }
    
    /**
     * @Route("{id}/edit", name="reservationbundle_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ReservationBundle:Salle')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Salle entity.');
        }

        $editForm = $this->createEditForm($entity);

        return array(
            'salle'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }
    
    
    // Vue RESERVATIONS
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
    
    
    //Formulaire RESERVER
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
			array()
		);
		
		$form->handleRequest($request);
		
		if($form->isValid())
		{
			$em = $this->getDoctrine()->getManager();
			
			$salle = $reservation->getSalle();
			$dateD = $reservation->getDateDebut();
			$dateF = $reservation->getDateFin();
			
			$resas = $salle->getReservations();
			
			$ok = $resas->count() > 0 ? false : true;
			
			foreach($resas as $resa) {
				if($dateD < $resa->getDateDebut() && $dateF < $resa->getDateDebut()) {
					$ok = true;
				}
				if($dateD > $resa->getDateFin() && $dateF > $resa->getDateFin()) {
					$ok = true;
				}
			}
			
			if($ok == true && $dateD < $dateF) {
				
			$em->persist($reservation);
			$em->flush();
			
			return $this->redirect($this->generateUrl('reservationbundle_reservations'));
			
			}
			else {
				
				$this->get('session')->getFlashBag()->add(
            'attention',
            'Impossible d\'effectuer une réservation de cette salle pour cette date et ces horaires...'
			);
			
			}
			
		}
							
        return array(
			'formulaire_reservation' => $form->createView()
		);
    }
    
    
    //Formulaire RESERVER salle choisie
    /**
     * @Route("/reserver/{id}", name="reservationbundle_reserverSalle")
     * @Template()
     */
    public function reserverSalleAction(Request $request, $id)
    {		
		
		$reservation = new Reservation();
		
		$em = $this->getDoctrine()->getManager();
		$repoSalles = $em->getRepository('ReservationBundle:Salle');
		
		$salle = $repoSalles->findOneById($id);	
		
		$reservation->setSalle($salle);
		
		$form = $this->createForm(
			new resaSalleType(),
			$reservation,
			array()
		);
		
		$form->handleRequest($request);
		
		if($form->isValid())
		{
			$em = $this->getDoctrine()->getManager();	
			
			$dateD = $reservation->getDateDebut();
			$dateF = $reservation->getDateFin();
			
			$resas = $salle->getReservations();
			
			$ok = $resas->count() > 0 ? false : true;
			
			foreach($resas as $resa) {
				if($dateD < $resa->getDateDebut() && $dateF < $resa->getDateDebut()) {
					$ok = true;
				}
				if($dateD > $resa->getDateFin() && $dateF > $resa->getDateFin()) {
					$ok = true;
				}
			}
			
			if($ok == true && $dateD < $dateF) {
					
			$em->persist($reservation);
			$em->flush();
			
			return $this->redirect($this->generateUrl('reservationbundle_salles'));	
			}
			else {
				
				$this->get('session')->getFlashBag()->add(
            'attention_resa',
            'Impossible d\'effectuer une réservation de la salle pour cette date et ces horaires...'
			);		
			}
		}
							
        return array(
			'formulaire_reservation' => $form->createView()
		);
    }
    
    
    // SUPPRESSION reservation
    /**
     * @Route("/reservations/suppression/{id}", name="reservationbundle_supprimerResa", requirements={"id"="\d+"})
     * @Template()
     */
    public function supprimerResaAction($id)
    {		
		$em = $this->getDoctrine()->getManager();
		$repoResas = $em->getRepository('ReservationBundle:Reservation');
		
		$resa = $repoResas->findOneById($id);

		if(!$resa) {
			throw $this->createNotFoundException('La reservation avec l\'id '.$id.' n\'existe pas...');
		}
		
        $em->remove($resa);
        $em->flush();

        return $this->redirect($this->generateUrl('reservationbundle_reservations'));
    }
}
