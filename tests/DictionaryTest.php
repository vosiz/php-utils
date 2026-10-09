<?php

use PHPUnit\Framework\TestCase;
use Vosiz\Utils\Collections\Dictionary;
use Vosiz\Utils\Collections\DictionaryException;
use Vosiz\Utils\Collections\CollectionException;

class DictionaryTest extends TestCase {

    /** @test */
    public function PlainPairIsRefusedWithDictionaryException() {

        $this->expectException(DictionaryException::class);

        (new Dictionary())->Add(new KeyValuePair('k', 1));
    }

    /** @test */
    public function StrictPairIsStoredUnderOneKey() {

        $d = new Dictionary();
        $d->Add(new KeyValuePairStrict('my_key', 7));

        $this->assertSame(['MyKey'], array_keys($d->ToPairs()));
        $this->assertSame(['MyKey' => 7], $d->ToArray());
    }

    /** @test */
    public function ExistingKeyIsNotOverwrittenBeforeException() {

        $d = new Dictionary();
        $d->Add(new KeyValuePairStrict('my_key', 7));

        try {

            $d->Add(new KeyValuePairStrict('MyKey', 8));
            $this->fail('CollectionException expected');

        } catch(CollectionException $exc) {

            $this->assertSame(7, $d->ToPairs()['MyKey']->GetValue());
        }
    }

    /** @test */
    public function RemoveKeepsBothStoresInAgreement() {

        $d = new Dictionary(['a' => 1, 5, 6, 'c' => 3]);

        $d->Remove(0);

        $this->assertSame(['A' => 1, 0 => 6, 'C' => 3], $d->ToArray());
        $this->assertSame($d->ToArray(), iterator_to_array($d));
    }

    /** @test */
    public function StrictPairRefusesFloatKey() {

        $this->expectException(KeyValuePairException::class);

        new KeyValuePairStrict(1.5, 1);
    }

    /** @test */
    public function StrictPairAcceptsNumericString() {

        $this->assertSame('1.5', (new KeyValuePairStrict('1.5', 1))->GetKey());
    }
}
