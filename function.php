<?php
include "connection/koneksi.php";

// User Define Function Login
function login() {
    global $conn;
    $username = $_REQUEST['username'];
    $password = $_REQUEST['password'];
    $akun = mysqli_query($conn, "select * from tb_user natural join tb_level");

    // Perulangan
    while($r = mysqli_fetch_array($akun)){
        //Kondisi cek username dan password
        if($r['username'] == $username and $r['password'] == $password and $r['status'] == 'aktif'){
            //menyimpan session username, id_user dan id_level
            $_SESSION['username'] = $username;
            $_SESSION['id_user'] = $r['id_user'];
            $_SESSION['level'] = $r['id_level'];
            //cek remember me
            if(isset($_POST['remember'])){
                //buat cookie
                setcookie("id", $r['id_user'], time()+3600);
                setcookie("key",hash('sha256',$r['username']), time()+3600);
            }
            //cek session, jika session
            $_SESSION['login'] = true;
            header('location: beranda.php');
            break;
        } else {
            $_SESSION['eror'] = 'salah';
            header('location: index.php');
        }
        
    }
}
// Function Register
function daftar(){
    global $conn;
    $nama_user = $_POST['nama_user'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $id_level = $_POST['id_level'];
    $status = 'nonaktif';
    $query_daftar = "insert into tb_user values ('','$username','$password','$nama_user','$id_level','$status')";
    $sql_daftar = mysqli_query($conn, $query_daftar);
    if($sql_daftar){
    header('location: index.php');
    $_SESSION['daftar'] = 'sukses';
    }
}

//getdata
function getData($query){
   global $conn;
   $result = mysqli_query($conn,$query);
   $rows = [];
   while ($row = mysqli_fetch_array($result)){
    $rows[] = $row;
   }
   return $rows;
}

//cari order



//hapus pesan
function hapus_pesan(){
    global $conn;
    $id_pesan = $_POST['hapus_pesan'];
    $query_hapus_pesan = "delete from tb_pesan where id_pesan = $id_pesan";
    $sql_hapus_pesan = mysqli_query($conn, $query_hapus_pesan);

    if($sql_hapus_pesan){
      header('location: entri_order.php');
    }
}
//tambah pesan
function tambah_pesan(){
    global $conn,$id_pesannya,$id,$sql_olah_stok;
    $id_masakan = $_REQUEST['tambah_pesan'];

    $query_tambah_pesan = "insert into tb_pesan values('', '$id', '', '$id_masakan', '', '')";
    $sql_tambah_pesan= mysqli_query($conn, $query_tambah_pesan);

    $query_lihat_pesannya = "select * from tb_pesan order by id_pesan desc limit 1";
    $sql_lihat_pesannya = mysqli_query($conn, $query_lihat_pesannya);
    $result_lihat_pesannya = mysqli_fetch_array($sql_lihat_pesannya);

    $id_pesannya = $result_lihat_pesannya['id_pesan'];

    $query_olah_stok = "insert into tb_stok values('', '$id_pesannya', '', 'belum cetak')";
    $sql_olah_stok= mysqli_query($conn, $query_olah_stok);

    //echo $query_tambah_pesan;
    if($sql_tambah_pesan){
        header('location: entri_order.php');
  }
}

//proses pesan
function proses_pesan(){
    global $conn,$id,$sql_kelola_stok,$sql_kurangi_stok,$sql_proses_ubah;
    $id_admin = '';
    $id_pengunjung = $id;
    $no_meja = $_POST['no_meja'];
    $total_harga = $_POST['total_harga'];
    $uang_bayar = '';
    $uang_kembali = '';
    $status_order = 'belum bayar';

    date_default_timezone_set('Asia/Jakarta');
    $time = Date('YmdHis');
    echo $time;
    $query_simpan_order = "insert into tb_order values('', '$id_admin', '$id_pengunjung', $time, '$no_meja', '$total_harga', '$uang_bayar', '$uang_kembali', '$status_order')";
    $sql_simpan_order = mysqli_query($conn, $query_simpan_order);

    $query_tampil_order = "select * from tb_order where id_pengunjung = $id order by id_order desc limit 1";
    $sql_tampil_order = mysqli_query($conn, $query_tampil_order);
    $result_tampil_order = mysqli_fetch_array($sql_tampil_order);

    $id_ordernya = $result_tampil_order['id_order'];

    $query_ubah_jumlah = "select * from tb_pesan left join tb_masakan on tb_pesan.id_masakan = tb_masakan.id_masakan where id_user = $id and status_pesan != 'sudah'";
    $sql_ubah_jumlah = mysqli_query($conn, $query_ubah_jumlah);
    while($r_ubah_jumlah = mysqli_fetch_array($sql_ubah_jumlah)){
      $tahu = $r_ubah_jumlah['id_masakan'];
      $tempe = $_POST['jumlah'.$tahu];
      $id_pesan = $r_ubah_jumlah['id_pesan'];
      $query_stok = "select * from tb_masakan where id_masakan = $tahu";
      $sql_stok = mysqli_query($conn, $query_stok);
      $result_stok = mysqli_fetch_array($sql_stok);
      $sisa_stok = $result_stok['stok'] - $tempe;
      //echo $tempe;
      $query_proses_ubah = "update tb_pesan set jumlah = $tempe, id_order = $id_ordernya where id_masakan = $tahu and id_user = $id and status_pesan != 'sudah'";
      $query_kurangi_stok = "update tb_masakan set stok = $sisa_stok where id_masakan = $tahu";
      
      $query_kelola_stok = "update tb_stok set jumlah_terjual = $tempe where id_pesan = $id_pesan";

      $sql_kelola_stok = mysqli_query($conn, $query_kelola_stok);
      $sql_kurangi_stok = mysqli_query($conn, $query_kurangi_stok);
      $sql_proses_ubah = mysqli_query($conn, $query_proses_ubah);
    }

    if($sql_simpan_order){
      header('location: entri_order.php');
    }
}

///cari menu
function cari($keyword){
    global $conn;
    $query = "SELECT * from tb_masakan where  nama_masakan LIKE '%$keyword%' order by id_masakan desc";
    return getData($query);

}
  




?>

