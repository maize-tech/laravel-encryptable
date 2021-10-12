<?php

namespace Maize\Encryptable;

use Illuminate\Contracts\Encryption\EncryptException;
use Illuminate\Database\Query\Grammars\PostgresGrammar;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DBEncrypter extends Encrypter
{
    private $grammar;

    public function __construct()
    {
        $this->grammar = DB::query()->getGrammar();
    }

    public function encrypt($value, bool $serialize = true): ?string
    {
        throw new EncryptException('Operation not supported.');
    }

    public function decrypt(?string $payload, bool $unserialize = true)
    {
        if (is_null($payload)) {
            return null;
        }

        if ($this->grammar instanceof PostgresGrammar) {
            $grammar = $this->getPostgresGrammarDecrypt();
        } else {
            $grammar = $this->getMysqlGrammarDecrypt();
        }

        return sprintf(
            $grammar,
            $payload,
            $this->getEncryptionKey(),
            $this->getEncryptionCipherAlgorithm()
        );
    }

    protected function getMysqlGrammarDecrypt(): string
    {
        return "CONVERT( SUBSTRING_INDEX( AES_DECRYPT( FROM_BASE64(%s), '%s' ), ':', -1 ) USING 'UTF8' )";
    }

    protected function getPostgresGrammarDecrypt(): string
    {
        return "split_part( convert_from( decrypt( decode(%s, 'base64'), '%s', '%s'), 'UTF8' ), ':', 3 )";
    }

    protected function getEncryptionCipherAlgorithm(): string
    {
        $cipher = $this->getEncryptionCipher();

        $algorithm = Str::before($cipher, '-');
        $mode = Str::afterLast($cipher, '-');

        return "{$algorithm}-{$mode}";
    }
}
