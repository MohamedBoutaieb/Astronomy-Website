<?php


namespace App\Command;


use App\Repository\ContactRepository;
use App\Repository\UserRepository;
use App\Services\ContactService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Validator\Constraints\Email;

class SendContactCommand extends Command
//quand on étend une commande on doit avoir un certain nombre de fonctions et notamment la fonction execute qui va contenir notre logique associé à
//notre commande
{
    private $contactRepository;
    private $mailer;
    private $contactService;//pour mettre à jour la partie isSent
    private $userRepository;
    //à taper après symfony console qui permet d'exécuter la fonction execute
    protected static $defaultName = 'app:send_contact';

    public function __construct(
        ContactRepository $contactRepository,
        MailerInterface $mailer,
        ContactService $contactService)
    {
        $this->contactRepository = $contactRepository;
        $this->contactService = $contactService;
        $this->mailer = $mailer;
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        //recupérer les msg qui sont en attente d'envoi
        $toSend = $this->contactRepository->findBy(['isSend' => false]);
        //pour chaque email qui n'est pas envoyé , on crée un email
        foreach ($toSend as $mail) {
            $email = (new Email())
                ->from($mail->getEmail())
                ->to('insat.astronomy@gmail.com')
                ->subject('New message sent by' . $mail->getName())
                ->text($mail->getMessage());
            $this->mailer->send($email);
            $this->contactService->isSend($mail);
        }
        return Command::SUCCESS;
    }

}