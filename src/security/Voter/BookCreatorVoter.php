<?php

namespace App\security\Voter;

use App\Entity\Book;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class BookCreatorVoter extends Voter
{

    /**
     * @inheritDoc
     */
    protected function supports(string $attribute, mixed $subject): bool
    {
        // TODO: Implement supports() method.
        return  "book.is _creator"== $attribute && $subject instanceof Book;
    }

    /**
     * @inheritDoc
     */
    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {

        $user = $token->getUser();
        if (!$user instanceof User){
            return false;
        }
        /** @var Book $subject */
        return $user === $subject->getCreatedby();
    }
}