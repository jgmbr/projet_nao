<?php

namespace NBGraphics\CoreBundle\Security;

use NBGraphics\CoreBundle\Entity\Observation;
use NBGraphics\UserBundle\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class ObservationVoter extends Voter
{
    const SHOW = 'show';
    const EDIT = 'edit';
    const DELETE = 'delete';
    const MODERATE = 'moderate';

    private $decisionManager;

    public function __construct(AccessDecisionManagerInterface $decisionManager)
    {
        $this->decisionManager = $decisionManager;
    }

    protected function supports($attribute, $subject)
    {
        // if the attribute isn't one we support, return false
        if (!in_array($attribute, array(self::SHOW, self::EDIT, self::DELETE, self::MODERATE))) {
            return false;
        }

        // only vote on Observation objects inside this voter
        if (!$subject instanceof Observation) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            // the user must be logged in; if not, deny access
            return false;
        }

        // ROLE_ADMIN can do anything on Observation! The power!
        if ($this->decisionManager->decide($token, array('ROLE_ADMIN'))) {
            return true;
        }

        // you know $subject is a Observation object, thanks to supports

        /** @var Observation $observation */
        $observation = $subject;

        switch ($attribute) {
            case self::SHOW:
                return $this->canShow($observation, $user);
            case self::EDIT:
                return $this->canEdit($observation, $user);
            case self::DELETE:
                return $this->canDelete($observation, $user);
            case self::MODERATE:
                return $this->canModerate($observation, $user);
        }

        throw new \LogicException('Ce code ne doit pas être atteind !');
    }

    private function canShow(Observation $observation, User $user)
    {
        return $user === $observation->getUser();
    }

    private function canEdit(Observation $observation, User $user)
    {
        return $user === $observation->getUser();
    }

    private function canDelete(Observation $observation, User $user)
    {
        return $user === $observation->getUser();
    }

    private function canModerate(Observation $observation, User $user)
    {
        return $user === $observation->getUser();
    }

}
