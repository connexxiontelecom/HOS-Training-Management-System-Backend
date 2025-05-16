<?php

namespace App\Auth;
use DateTimeZone;
use Lcobucci\Clock\SystemClock;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Token;
use Lcobucci\JWT\UnencryptedToken;
use Lcobucci\JWT\Validation\Constraint;
use Lcobucci\JWT\Validation\Constraint\StrictValidAt;
use Lcobucci\JWT\Validation\ConstraintViolation;
use Lcobucci\JWT\Validation\Constraint\SignedWith;
use Lcobucci\JWT\Validation\Constraint\IdentifiedBy;
use DateTimeImmutable;
use Lcobucci\JWT\Validation\RequiredConstraintsViolated;

class  JwtAuthServices{
    public $config;

    public function initConfig(){
        $this->config = Configuration::forSymmetricSigner(new Sha256(), InMemory::plainText('!@LfrtWYbF5uWb0GLWjwDigrMb722yJgAp2B3jDoYYRzYOSjIU3PHwRIpGSZlgaPassword123?'));
    }

    public function init($uniqueid, $type = 'access', $expiration = '+12 hour')
    {
        $this->initConfig();
        $randomString = substr(sha1(time()), 28, 40);
        $now   = new DateTimeImmutable();
       $token = $this->config->builder()
           ->relatedTo("Wemoove")
            // Configures the issuer (iss claim)
            ->issuedBy('com.connexxion.wemoove')
            // Configures the audience (aud claim)
            ->permittedFor('com.connexxion.wemoove')
            // Configures the id (jti claim)
            ->identifiedBy($uniqueid)
            // Configures the time that the token was issue (iat claim)
            ->issuedAt($now)
            // Configures the time that the token can be used (nbf claim)
            ->canOnlyBeUsedAfter($now->modify('+1 second'))
            // Configures the expiration time of the token (exp claim)
            ->expiresAt($now->modify($expiration))
            // Configures a new claim, called "uid"
            ->withClaim('uid', $randomString)
            ->withClaim('type', $type)
           // Configures a new header, called "foo"
            //->withHeader('foo', 'bar')
            // Builds a new token
            ->getToken($this->config->signer(), $this->config->signingKey());
       return $token->toString();
    }


    public function getTokenData($jwttoken){
        $this->initConfig();
        $token = $this->config->parser()->parse($jwttoken);
    }

    public function parseToken($jwttoken, $tokenType = 'access'){
        $this->initConfig();
        $token = $this->config->parser()->parse($jwttoken);
        assert($token instanceof UnencryptedToken);
        $clock = new SystemClock(new DateTimeZone('UTC'));
        //$clock = new SystemClock(new DateTimeZone(Timezone Variable));

        $this->config->setValidationConstraints(
            //new IdentifiedBy('useruniqueid'),
            new SignedWith($this->config->signer(), $this->config->verificationKey()),
            new StrictValidAt($clock)
        );
        $constraints = $this->config->validationConstraints();

        if (!$this->config->validator()->validate($token, ...$constraints)) {
            //throw new RuntimeException('No way!');
            return false;
        }


        $claims = $token->claims();
        $type = $claims->get('type');
        if ($type !== $tokenType) {
            return false;
        }

        return true;



        /*try {
            $constraints = $this->config->validationConstraints();
            $this->config->validator()->assert($token, ...$constraints);
            //return "valid";
        } catch (RequiredConstraintsViolated $e) {
            // list of constraints violation exceptions:
           // var_dump($e->violations());
            return "Unauthorized token";
        }*/
    }

}


