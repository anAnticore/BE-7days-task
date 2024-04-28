<?php

declare(strict_types=1);

namespace App\Command;

use App\Entity\Post;
use App\Repository\PostRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AddPostCommand extends Command
{
    protected static $defaultName = 'app:add-post';
    protected static $defaultDescription = 'Run app:add-post';

    private PostRepository $postRepository;

    public function __construct(PostRepository $postRepository, string $name = null)
    {
        $this->postRepository = $postRepository;

        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this->addArgument('title')
            ->addArgument('content');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $title = $input->getArgument('title');
        $content = $input->getArgument('content');

        if (is_string($title) && is_string($content)) {
            $post = new Post();
            $post->setTitle($title);
            $post->setContent($content);

            $this->postRepository->add($post);

            $output->writeln('The post has been added.');

            return Command::SUCCESS;
        }

        $output->writeln('The post not has been added, expected that input args are strings');

        return Command::FAILURE;
    }
}
