<?php

namespace App\Serializer\Normalizer;

use App\Entity\Category;
use Symfony\Component\Serializer\Normalizer\CacheableSupportsMethodInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class CategoryNormalizer implements NormalizerInterface, CacheableSupportsMethodInterface
{
    public function __construct(private ObjectNormalizer $normalizer)
    {
    }

    public function normalize($object, string $format = null, array $context = []): array
    {
        $data = $this->normalizer->normalize($object, $format, $context);

        if (!$object instanceof Category) {
            return $data;
          }

        if ($object->getParent()) {
            $data['parent'] = $object->getParent()->getName();
        }

        return $data;
    }

    public function supportsNormalization($data, string $format = null, array $context = []): bool
    {
        return $data instanceof Category;
    }

    public function hasCacheableSupportsMethod(): bool
    {
        return true;
    }
}
