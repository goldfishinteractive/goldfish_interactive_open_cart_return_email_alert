<?php
class ControllerMailReturn extends Controller {
	public function index(&$route, &$args, &$output) {

 	}
	
	public function alert(&$route, &$args, &$output) {
	    $this->load->model('account/return');

        $return_info = $this->model_account_return->getReturn(intval($output));

        if ($return_info) {
            $this->load->language('mail/return');

            $data['return_id'] = $return_info['return_id'];
            $data['order_id'] = $return_info['order_id'];
            $data['firstname'] = $return_info['firstname'];
            $data['lastname'] = $return_info['lastname'];
            $data['email'] = $return_info['email'];
            $data['telephone'] = $return_info['telephone'];
            $data['product'] = $return_info['product'];
            $data['model'] = $return_info['model'];
            $data['quantity'] = $return_info['quantity'];
            $data['opened'] = $return_info['opened'];
            $data['reason'] = $return_info['reason'];
            $data['action'] = $return_info['action'];
            $data['status'] = $return_info['status'];
            $data['comment'] = strip_tags(html_entity_decode($return_info['comment'], ENT_QUOTES, 'UTF-8'));
            $data['date_ordered'] = date($this->language->get('date_format_short'), strtotime($return_info['date_ordered']));
            $data['date_added'] = date($this->language->get('date_format_short'), strtotime($return_info['date_added']));
            $data['date_modified'] = date($this->language->get('date_format_short'), strtotime($return_info['date_modified']));

            $mail = new Mail($this->config->get('config_mail_engine'));
            $mail->parameter = $this->config->get('config_mail_parameter');
            $mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
            $mail->smtp_username = $this->config->get('config_mail_smtp_username');
            $mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
            $mail->smtp_port = $this->config->get('config_mail_smtp_port');
            $mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');

            $mail->setFrom($this->config->get('config_email'));
            $mail->setSender(html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8'));
            $mail->setSubject(sprintf($this->language->get('text_subject'), html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8'), $return_info['return_id']));
            $mail->setText($this->load->view('mail/return_alert', $data));
            $mail->setTo($this->config->get('config_email'));
            $mail->send();

            // Send to additional alert emails if new affiliate email is enabled
            $emails = explode(',', $this->config->get('config_mail_alert_email'));

            foreach ($emails as $email) {
                if (utf8_strlen($email) > 0 && filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $mail->setTo($email);
                    $mail->send();
                }
            }
        }
	}
}		