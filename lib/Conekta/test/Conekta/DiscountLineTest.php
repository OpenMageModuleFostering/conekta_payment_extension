<?php

class DiscountLineTest extends UnitTestCase
{
    public static $valid_order =
        array(
            'line_items'=> array(
                array(
                    'name'=> 'Box of Cohiba S1s',
                    'description'=> 'Imported From Mex.',
                    'unit_price'=> 20000,
                    'quantity'=> 1,
                    'sku'=> 'cohb_s1',
                    'category'=> 'food',
                    'type' => 'physical',
                    'tags' => array('food', 'mexican food')
                )
            ),
            'currency'    => 'mxn',
            'discount_lines' => array(
                array(
                    'description' => 'Cupon de descuento',
                    'amount' => 10,
                    'kind' => 'loyalty'
                ),
                array(
                    'description' => 'Cupon de descuento',
                    'amount' => 5,
                    'kind' => 'loyalty'
                )
            )
        );

    public function testSuccessfulDiscountLineDelete()
    {
        setApiKey();
        setApiVersion('1.1.0');
        $order = \Conekta\Order::create(self::$valid_order);
        $discount_line = $order->discount_lines[0];
        $discount_line->delete();

        $this->assertTrue($discount_line->deleted == true);
    }

    public function testSuccessfulDiscountLineUpdate()
    {
        setApiKey();
        setApiVersion('1.1.0');
        $order = \Conekta\Order::create(self::$valid_order);
        $discount_line = $order->discount_lines[0];
        $discount_line->update(array('amount' => 11));

        $this->assertTrue($discount_line->amount == 11);
    }

    public function testUnsuccessfulDiscountLineUpdate()
    {
        setApiKey();
        setApiVersion('1.1.0');
        $order = \Conekta\Order::create(self::$valid_order);
        $discount_line = $order->discount_lines[0];
        try{
            $discount_line->update(array('amount' => -1));
        } catch(Exception $e) {
            $this->assertTrue(strpos(get_class($e), 'ErrorList') == true);
        }
    }

}