    <div class="card">
            <div class="card-body">
                 <h5 class="card-title"> <?= $post->getName() ?> </h5>
                 <p class="text-muted"> <?= $post->getCreated_at()->format('d/m/Y') ?> </p>
                 <p> <?= $post->getExcerpt() ?> </p>
                 <p>
                    <a href="<?= $router->url('post', ['id' => $post->getID(), 'slug' => $post->getSlug()] ) ?>" class="btn btn-primary" > Voir plus </a>
                 </p>
            </div>
    </div>