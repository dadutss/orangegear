<?php
defined('_JEXEC') or die;

class plgHikashopShippingemail extends JPlugin {

    public function onBeforeMailPrepare(&$mail, &$mailer, &$do) {

        // Only target HikaShop order emails
        if (empty($mail->vars)) {
            return;
        }

        // Ensure order exists
        if (empty($mail->vars['order'])) {
            return;
        }

        $order = $mail->vars['order'];

        // Determine shipping address safely
        $shipping = null;

        if (!empty($order->shipping_address)) {
            $shipping = $order->shipping_address;
        } elseif (!empty($order->billing_address)) {
            $shipping = $order->billing_address;
        }

        if (!$shipping) {
            return;
        }

        // FORCE SHIPPING globally
        $mail->vars['shipping_address'] = $shipping;
        $mail->vars['billing_address']  = $shipping;

        // Optional: if address helper expects formatted output already
        if (is_object($shipping)) {
            $mail->vars['billing_address'] = $shipping;
            $mail->vars['shipping_address'] = $shipping;
        }
    }
}
