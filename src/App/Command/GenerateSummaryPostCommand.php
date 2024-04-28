<?php

declare(strict_types=1);

namespace App\Command;

use App\Entity\Post;
use joshtronic\LoremIpsum;
use App\Repository\PostRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateSummaryPostCommand extends Command
{
    protected static $defaultName = 'app:generate-summary-post';
    protected static $defaultDescription = 'Run app:generate-summary-post';

    private PostRepository $postRepository;
    private LoremIpsum $loremIpsum;

    public function __construct(
        PostRepository $postRepository,
        LoremIpsum $loremIpsum,
        ?string $name = null
    ) {
        parent::__construct($name);
        $this->postRepository = $postRepository;
        $this->loremIpsum = $loremIpsum;
    }

    protected function configure(): void
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $title = \sprintf('Summary %s', \date('Y-m-d'));
        /** @var string|string[] $content */
        $content = $this->loremIpsum->paragraphs(1);

        if (is_array($content) === true) {
            $output->writeln('A summary post has not been generated. Content must be string');

            return Command::FAILURE;
        }

        $post = new Post();
        $post->setTitle($title);
        $post->setContent($content);

        $this->postRepository->add($post, true);

        $output->writeln('A summary post has been generated.');

        return Command::SUCCESS;
    }
}
