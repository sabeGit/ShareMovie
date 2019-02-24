<?php

interface UserRepository {

    public function create($, $email, $password_hash);

}

class EloquentPostRepository implements PostRepository {
    private $post;

    public function __construct(Post $post) {
        $this->post = $post;
    }

    public fucntion create($watched, $review, $movieId) {
        $data = [];
        $data['name'] = $name;
        $data['email'] = $email;
        $data[] = $password_hash;

        return $this->user->create(data);
    }
}
