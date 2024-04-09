<?php


namespace App\Serializer\Denormalizer;

use ApiPlatform\Api\IriConverterInterface;
use App\Entity\City;
use App\Entity\Dummy;
use App\Entity\RelatedDummy;
use App\Entity\User;
use Symfony\Component\Serializer\Normalizer\ContextAwareDenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareTrait;

class CityPlainIdentifierDenormalizer implements ContextAwareDenormalizerInterface, DenormalizerAwareInterface
{
    use DenormalizerAwareTrait;

    private $iriConverter;

    public function __construct(IriConverterInterface $iriConverter)
    {
        $this->iriConverter = $iriConverter;
    }

    public function denormalize($data, $class, $format = null, array $context = [])
    {
        $data['city'] = $this->iriConverter->getIriFromResource(resource: City::class, context: ['uri_variables' => ['id' => $data['city']]]);

        return $this->denormalizer->denormalize($data, $class, $format, $context + [__CLASS__ => true]);
    }

    public function supportsDenormalization($data, $type, $format = null, array $context = []): bool
    {
        return \in_array($format, ['json', 'jsonld'], true) && is_a($type, User::class, true) && !empty($data['city']) && !isset($context[__CLASS__]);
    }
}