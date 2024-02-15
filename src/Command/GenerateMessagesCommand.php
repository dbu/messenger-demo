<?php

declare(strict_types=1);

namespace App\Command;

use App\Message\NeuromancerMessage;
use App\Message\WintermuteMessage;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsCommand(
    name: 'app:generate-messages',
    description: 'Generate some messages with William Gibson quotes to fill the queues',
)]
class GenerateMessagesCommand extends Command
{
    /**
     * Quotes from William Gibson.
     */
    private const WINTERMUTE = [
'The future is there... looking back at us. Trying to make sense of the fiction we will have become.',
        'The future is already here – it\'s just not evenly distributed.',
    'The sky above the port was the color of television, tuned to a dead channel.',
'Cyberspace. A consensual hallucination experienced daily by billions of legitimate operators, in every nation, by children being taught mathematical concepts... A graphic representation of data abstracted from banks of every computer in the human system. Unthinkable complexity. Lines of light ranged in the nonspace of the mind, clusters and constellations of data. Like city lights, receding...',
        'When you want to know how things really work, study them when they\'re coming apart.',
        'Before you diagnose yourself with depression or low self-esteem, first make sure that you are not, in fact, just surrounded by assholes.',
        'The \'Net is a waste of time, and that\'s exactly what\'s right about it.',
        'All the speed he took, all the turns he\'d taken and the corners he\'d cut in Night City, and still he\'d see the matrix in his sleep, bright lattices of logic unfolding across that colorless void...',
'We have sealed ourselves away behind our money, growing inward, generating a seamless universe of self.',
        'Night City was like a deranged experiment in social Darwinism, designed by a bored researcher who kept one thumb permanently on the fast-forward button',
    ];

    private const NEUROMANCER = [
        'Time moves in one direction, memory another. We are that strange species that constructs artifacts intended to counter the natural flow of forgetting',
        'I think I\'d probably tell you that it\'s easier to desire and pursue the attention of tens of millions of total strangers than it is to accept the love and loyalty of the people closest to us.',
        'And, for an instant, she stared directly into those soft blue eyes and knew, with an instinctive mammalian certainty, that the exceedingly rich were no longer even remotely human.',
        'One of the liberating effects of science fiction when I was a teenager was precisely its ability to tune me into all sorts of strange data and make me realize that I wasn’t as totally isolated in perceiving the world as being monstrous and crazy',
        'We see in order to move; we move in order to see.',
        'Stand high long enough and your lightning will come.',
        'When the past is always with you, it may as well be present; and if it is present, it will be future as well.',
'We have no future because our present is too volatile. We have only risk management. The spinning of the given moment\'s scenarios. Pattern recognition.',
        'His eyes were eggs of unstable crystal, vibrating with a frequency whose name was rain and the sound of trains, suddenly sprouting a humming forest of hair-fine glass spines.',
    ];

    public function __construct(
        private MessageBusInterface $messageBus,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addOption('count', null, InputOption::VALUE_REQUIRED, 'How many messages to generate into each queue', 10)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $count = $input->getOption('count');
        for ($i = 0; $i < $count; ++$i) {
            $this->messageBus->dispatch(new WintermuteMessage(self::WINTERMUTE[array_rand(self::WINTERMUTE)]));
            $this->messageBus->dispatch(new NeuromancerMessage(self::NEUROMANCER[array_rand(self::NEUROMANCER)]));
        }

        $io->success("Generated $count messages for each queue");

        return Command::SUCCESS;
    }
}
