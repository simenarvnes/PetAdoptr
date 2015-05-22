<?php

session_start();
include '../../dbauth_prototype.php';
include '../utils/database.php';

class EmailSender {
    function __construct() {
        $this->smtp_port = 465; //default port for Gmail
        $this->relay_host = "ssl://smtp.gmail.com"; // our gmail host
        $this->time_out = 30;
        $this->auth = true;
        $this->user = "pet.adoptr@gmail.com";
        $this->pass = "sweteam2";
        $this->host_name = "localhost";
        $this->sock = FALSE;
    }
    function send_mail($to, $from, $subject, $body, $mailtype, $returnpath) {
        $mail_from = $this->get_address($this->strip_comment($from));
        $body = ereg_replace("(^|(\r\n))(\.)", "\1.\3", $body);
        $header = "";
        if (isset($returnpath) && $returnpath != "") {
            $header.= "Reply-To:" . $returnpath . "\r\n";
        }
        $header.= "MIME-Version:1.0\r\n";
        if ($mailtype == "HTML") {
            $header.= 'Content-Type:text/html; charset=utf-8' . "\r\n";
        }
        $header.= "To: " . $to . "\r\n";
        $header .= "From: $from<" . $from . ">\r\n";
        $header .= "Subject: " . $subject . "\r\n";
        $header .= "Date: " . date("r") . "\r\n";
        $header .= "X-Mailer:By Redhat (PHP/" . phpversion() . ")\r\n";
        list($msec, $sec) = explode(" ", microtime());
        $header.= "Message-ID: <" . date("YmdHis", $sec) . "." . ($msec * 1000000) . "." . $mail_from . ">\r\n";
        $TO = explode(",", $this->strip_comment($to));

        $sent = TRUE;
        foreach ($TO as $rcpt_to) {
            $rcpt_to = $this->get_address($rcpt_to);
            if (!$this->smtp_sockopen($rcpt_to)) {
                $this->output_log("Error: can't send email to " . $rcpt_to . "\n");
                $sent = FALSE;
                continue;
            }
            if ($this->smtp_send($this->host_name, $mail_from, $rcpt_to, $header, $body)) {
                $this->output_log("E-mail has been sent to <" . $rcpt_to . ">\n");
            } else {
                $this->output_log("Error: can't send email to <" . $rcpt_to . ">\n");
                $sent = FALSE;
            }
            fclose($this->sock);
        }
        return $sent;
    }
    /* Private Functions */
    function smtp_send($helo, $from, $to, $header, $body = "") {
        if (!$this->smtp_putcmd("HELO", $helo)) {
            return $this->output_error("sending HELO command");
        }
        if ($this->auth) {
            if (!$this->smtp_putcmd("AUTH LOGIN", base64_encode($this->user))) {
                return $this->output_error("sending HELO command");
            }
            if (!$this->smtp_putcmd("", base64_encode($this->pass))) {
                return $this->output_error("sending HELO command");
            }
        }
        if (!$this->smtp_putcmd("MAIL", "FROM:<" . $from . ">")) {
            return $this->output_error("sending MAIL FROM command");
        }
        if (!$this->smtp_putcmd("RCPT", "TO:<" . $to . ">")) {
            return $this->output_error("sending RCPT TO command");
        }
        if (!$this->smtp_putcmd("DATA")) {
            return $this->output_error("sending DATA command");
        }
        if (!$this->smtp_message($header, $body)) {
            return $this->output_error("sending message");
        }
        if (!$this->smtp_eom()) {
            return $this->output_error("sending <CR><LF>.<CR><LF> [EOM]");
        }
        if (!$this->smtp_putcmd("QUIT")) {
            return $this->output_error("sending QUIT command");
        }
        return TRUE;
    }
    function smtp_sockopen($address) {
        if ($this->relay_host == "") {
            return $this->smtp_sockopen_mx($address);
        } else {
            return $this->smtp_sockopen_relay();
        }
    }
    function smtp_ok() {
        $response = str_replace("\r\n", "", fgets($this->sock, 512));
        if (!ereg("^[23]", $response)) {
            fputs($this->sock, "QUIT\r\n");
            fgets($this->sock, 512);
            $this->output_log("Error: Remote host returned \"" . $response . "\"\n");
            return FALSE;
        }
        return TRUE;
    }
    function smtp_sockopen_relay() {
        $this->sock = @fsockopen($this->relay_host, $this->smtp_port, $errno, $errstr, $this->time_out);
        if (!($this->sock && $this->smtp_ok())) {
            $this->output_log("Error: Cannot connenct to relay host " . $this->relay_host . "\n");
            $this->output_log("Error: " . $errstr . " (" . $errno . ")\n");
            return FALSE;
        }
        return TRUE;
    }
    function smtp_sockopen_mx($address) {
        $domain = ereg_replace("^.+@([^@]+)$", "\1", $address);
        if (!@getmxrr($domain, $MXHOSTS)) {
            $this->output_log("Error: Cannot resolve MX \"" . $domain . "\"\n");
            return FALSE;
        }
        foreach ($MXHOSTS as $host) {
            $this->output_log("Trying to " . $host . ":" . $this->smtp_port . "\n");
            $this->sock = @fsockopen($host, $this->smtp_port, $errno, $errstr, $this->time_out);
            if (!($this->sock && $this->smtp_ok())) {
                $this->output_log("Warning: Cannot connect to mx host " . $host . "\n");
                $this->output_log("Error: " . $errstr . " (" . $errno . ")\n");
                continue;
            }
            $this->output_log("Connected to mx host " . $host . "\n");
            return TRUE;
        }
        $this->output_log("Error: Cannot connect to any mx hosts (" . implode(", ", $MXHOSTS) . ")\n");
        return FALSE;
    }
    function smtp_message($header, $body) {
        fputs($this->sock, $header . "\r\n" . $body);
        return TRUE;
    }
    function smtp_eom() {
        fputs($this->sock, "\r\n.\r\n");
        return $this->smtp_ok();
    }
    function smtp_putcmd($cmd, $arg = "") {
        if ($arg != "") {
            if ($cmd == "")
                $cmd = $arg;
            else
                $cmd = $cmd . " " . $arg;
        }
        fputs($this->sock, $cmd . "\r\n");
        return $this->smtp_ok();
    }
    function strip_comment($address) {
        $comment = "\([^()]*\)";
        while (ereg($comment, $address)) {
            $address = ereg_replace($comment, "", $address);
        }
        return $address;
    }
    function get_address($address) {
        $address = ereg_replace("([ \t\r\n])+", "", $address);
        $address = ereg_replace("^.*<(.+)>.*$", "\1", $address);
        return $address;
    }
    function output_log($message) {
        echo $message;
    }
    function output_error($string) {
        $this->output_log("Error: Error occurred while " . $string . ".\n");
    }
}

if (empty($_POST['mail_subject']) || empty($_POST['mail_from'])
    || empty($_POST['mail_msg']) || empty($_POST['mail_pet_id'])
) {
    echo "Error: Can't send the email, invalid information!";
} else {
    $mail_subject = $_POST['mail_subject'];
    $mail_from = $_POST['mail_from'];
    $mail_msg = $_POST['mail_msg'];

    $pet_adopter = get_name_by_email($_SESSION['login_user']);

    list($owner_name, $owner_email) = get_owner_information($_POST['mail_pet_id']);

    $content = "Hi $owner_name, <br><br>$mail_msg<br><br>Best,<br>$pet_adopter";
    $content .= "<br><br><hr>This message is sent from <strong>PetAdoptr</strong>. ";
    $content .= "Reply this email and directly contact him/her!";

    $sender = new EmailSender();
    $sender->send_mail($owner_email, "Pet Adoptr", $mail_subject, $content, "HTML", $mail_from);
}