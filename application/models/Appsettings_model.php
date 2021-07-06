<?php





class Appsettings_model extends CI_model

{

    public function getappbyid()

    {

        return $this->db->get_where('app_settings', ['id' => '1'])->row_array();

    }



    public function gettransfer()

    {

        $this->db->select('*');

        $this->db->from('list_bank');

        return $this->db->get()->result_array();

    }



    public function getbankid($id)

    {

        $this->db->select('*');

        $this->db->from('list_bank');

        $this->db->where('id_bank', $id);

        return $this->db->get()->row_array();

    }



    public function ubahdataappsettings($data)

    {

        $this->db->set('app_logo', $data['app_logo']);

        $this->db->set('app_email', $data['app_email']);

        $this->db->set('app_website', $data['app_website']);



        $this->db->set('app_privacy_policy', $data['app_privacy_policy']);

        $this->db->set('app_book_guide', $data['app_book_guide']);

        $this->db->set('app_aboutus', $data['app_aboutus']);

        $this->db->set('app_address', $data['app_address']);

        $this->db->set('app_name', $data['app_name']);

        $this->db->set('app_linkgoogle', $data['app_linkgoogle']);

        $this->db->set('app_currency', $data['app_currency']);



        $this->db->where('id', '1');

        $this->db->update('app_settings', $data);

    }



    public function ubahdatarekening($data, $id)

    {

        $this->db->where('id_bank', $id);

        $this->db->update('list_bank', $data);

    }



    public function hapusrekening($id)

    {

        $this->db->where('id_bank', $id);

        $this->db->delete('list_bank');

    }



    public function adddatarekening($data)

    {

        $this->db->insert('list_bank', $data);

    }



    public function ubahdataemail($data)

    {

        $this->db->set('email_subject', $data['email_subject']);

        $this->db->set('email_text1', $data['email_text1']);

        $this->db->set('email_text2', $data['email_text2']);

        $this->db->set('email_subject_confirm', $data['email_subject_confirm']);

        $this->db->set('email_text3', $data['email_text3']);

        $this->db->set('email_text4', $data['email_text4']);



        $this->db->where('id', '1');

        $this->db->update('app_settings', $data);

    }



    public function ubahdatasmtp($data)

    {

        $this->db->set('smtp_host', $data['smtp_host']);

        $this->db->set('smtp_port', $data['smtp_port']);

        $this->db->set('smtp_username', $data['smtp_username']);

        $this->db->set('smtp_password', $data['smtp_password']);

        $this->db->set('smtp_from', $data['smtp_from']);

        $this->db->set('smtp_secure', $data['smtp_secure']);



        $this->db->where('id', '1');

        $this->db->update('app_settings', $data);

    }



    public function ubahdatastripe($data)

    {

        $this->db->set('stripe_secret_key', $data['stripe_secret_key']);

        $this->db->set('stripe_published_key', $data['stripe_published_key']);

        $this->db->set('stripe_status', $data['stripe_status']);

        $this->db->set('stripe_active', $data['stripe_active']);



        $this->db->where('id', '1');

        $this->db->update('app_settings', $data);

    }



    public function ubahdatapaypal($data)

    {

        $this->db->set('paypal_key', $data['paypal_key']);

        $this->db->set('app_currency_text', $data['app_currency_text']);

        $this->db->set('paypal_mode', $data['paypal_mode']);

        $this->db->set('paypal_active', $data['paypal_active']);



        $this->db->where('id', '1');

        $this->db->update('app_settings', $data);

    }



    public function getpayubyid()

    {

        return $this->db->get_where('payusettings', ['id' => '1'])->row_array();

    }



    public function ubahdatapayu($data)

    {

        $this->db->set('payu_key', $data['payu_key']);

        $this->db->set('payu_id', $data['payu_id']);

        $this->db->set('payu_salt', $data['payu_salt']);

        $this->db->set('payu_debug', $data['payu_debug']);

        $this->db->set('active', $data['active']);



        $this->db->where('id', '1');

        $this->db->update('payusettings', $data);

    }

}

