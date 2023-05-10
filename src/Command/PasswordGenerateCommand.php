<?php

namespace App\Command;

use App\Service\AcronymGeneratorInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:password-generate',
    description: 'Add a short description for your command',
)]
class PasswordGenerateCommand extends Command
{
    public function __construct(private readonly AcronymGeneratorInterface $generatorService)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('phrase', InputArgument::OPTIONAL, 'Type your phrase to generate a secure password');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $phrase = $input->getArgument('phrase');

        if ($phrase) {
            $io->note(sprintf('You passed as phrase: "%s"', $phrase));

            $acronym = $this->generatorService->generate($phrase);

            $io->info(sprintf('Here is your acronym: %s', $acronym['data']['acronym']));
        }

        return Command::SUCCESS;
    }
}
