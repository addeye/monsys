<?php
include 'Telegram.php';

date_default_timezone_set('Asia/Jakarta');
spl_autoload_register(function ($class) {
    include '../class/' . $class . '.php';
});

$user = new User();

$bot_token = '994163398:AAGLMfACOdayD9vuUPLL1MNjm1Jd1rpcXuA';
$telegram = new Telegram($bot_token);
$text = $telegram->Text();
$chat_id = $telegram->ChatID();
$first_name = $telegram->FirstName();
$last_name = $telegram->LastName();

if ($text == '/start') {
    $reply = 'Halo ' . $first_name . ' ' . $last_name . "\nSelamat datang saya MonBot\n\n";
    $reply .= "Saya akan mengirimkan notifikasi ke anda jika ada pemberitahuan dari Sistem Monsys\n\n";
    $reply .= 'Silahkan menampilkan info notifikasi anda dengan ketik /info';
    $content = ['chat_id' => $chat_id, 'text' => $reply];
    $telegram->sendMessage($content);
}

if ($text == '/info') {
    //cek apakah chatid skrg sudah terdaftar
    $u = $user->getByChatID($chat_id);

    if ($u) {
        $reply = "* \xE2\x9C\x85 Terdaftar pada *\n\n";
        $reply .= 'No Induk : ' . $u['NO_INDUK'] . "\n";
        $reply .= "Nama : " . $u['NAMA'] . "\n";
        $reply .= "Kelas : " . $u['KELAS'] . "\n\n";
        $reply .= "------------------------------------\n";
        $reply.= "Perbaruhi Data dengan \xE2\x9C\x8F Ketik /notif_<NIS SISWA>\n";
        $reply .= "Contoh : /notif_0101\n\n";
        $reply .= "------------------------------------\n";
        $reply.= "Matikan notifikasi dengan ketik /off\n\n";

        $content = ['chat_id' => $chat_id, 'text' => $reply];
        $telegram->sendMessage($content);
    } else {
        $reply = "\xF0\x9F\x98\xA2 Anda Belum Terdaftar\n\n";
        $reply .= "\xF0\x9F\x94\x94 Cara mendaftarkan Notifikasi\n\n";
        $reply .= "\xE2\x9C\x8F Ketik  /notif_<NIS SISWA>\n";
        $reply .= "Contoh : /notif_0101\n";
        $content = ['chat_id' => $chat_id, 'text' => $reply];
        $telegram->sendMessage($content);
    }
}

if(strpos($text, '/notif_') !== false && $text != '/notif_0101'){
    $tt = explode("_",$text);
    $nis = $tt[1];

    $siswa = $user->getById($nis);

    if($siswa){
        $user->updateChatID($chat_id,$nis);

        $reply = "* \xF0\x9F\x91\x8F Berhasil *\n\n";
        $reply .= "NIS : " . $siswa['NO_INDUK'] . "\n";
        $reply .= 'Nama : ' . $siswa['NAMA'] . "\n";
        $reply .= "Kelas : " . $siswa['KELAS'] . "\n";
    }else{
        $reply = "*\xE2\x9D\x8C Gagal! Siswa Tidak Ditemukan *";
    }
    $content = ['chat_id' => $chat_id, 'text' => $reply];
    $telegram->sendMessage($content);
}

if($text == '/notif_0101'){
    $reply = "\xF0\x9F\x98\x92 \n";
    $reply .= "/notif_0101 Ini Hanya Contoh Lakukan Dengan Benar! \xF0\x9F\x98\x93";
    $content = ['chat_id' => $chat_id, 'text' => $reply];
    $telegram->sendMessage($content);
}

if($text == '/off'){
    $r = $user->resetChatID($chat_id);
    if($r){
        $reply = "\xF0\x9F\x91\x8B Berhasil Reset\n";
    }else{
        $reply = "\xF0\x9F\x99\x8F Gagal Reset Karena ID Anda Tidak Terdaftar!\n";
    }

    $content = ['chat_id' => $chat_id, 'text' => $reply];
    $telegram->sendMessage($content);
}



// $content = ['chat_id' => $chat_id, 'text' => 'Hello'];
// $telegram->sendMessage($content);
