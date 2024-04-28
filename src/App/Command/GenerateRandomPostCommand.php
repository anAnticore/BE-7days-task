<?php

declare(strict_types=1);

namespace App\Command;

use App\Entity\Post;
use joshtronic\LoremIpsum;
use App\Repository\PostRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateRandomPostCommand extends Command
{
    protected static $defaultName = 'app:generate-random-post';
    protected static $defaultDescription = 'Run app:generate-random-post';

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
        /** @var string|string[] $title */
        $title = $this->loremIpsum->words(mt_rand(4, 6));

        /** @var string|string[] $content */
        $content = $this->loremIpsum->paragraphs(2);

        if (is_array($title) === false && is_array($content) === false) {
            $post = new Post();
            $post->setTitle($title);
            $post->setContent($content);

            $this->postRepository->add($post, true);

            $output->writeln('A random post has been generated.');

            return Command::SUCCESS;
        }

        $output->writeln('A random post not generated, expected that title and content not array.');

        return Command::FAILURE;
    }
}
