<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Session;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;


Route::get('/error-test', function () {
    Log::info('calling the error route');
    throw new \Exception('something unexpected broke');
});

Route::get('/maintenance', function () {
    Artisan::call('down');
});

Route::get('/production', function () {
    Artisan::call('up');
});

Route::post('/submit-form', function () {
    //
})->middleware(\Spatie\HttpLogger\Middlewares\HttpLogger::class);


Route::group(['namespace' => 'MataPelajaran'], function () {

    Route::group(['middleware' => 'authLogin'], function () {
        Route::get('/matapelajaran', 'MataPelajaran@index')->name('matapelajaranList');
        Route::post('/matapelajaran/datatable', 'MataPelajaran@data_table')->name('matapelajaranDataTable');
        Route::get('/matapelajaran/create', 'MataPelajaran@create')->name('matapelajaranCreate');
        Route::post('/matapelajaran/insert', 'MataPelajaran@insert')->name('matapelajaranInsert');
        Route::delete('/matapelajaran/delete/{id}', "MataPelajaran@delete")->name('matapelajaranDelete');
        Route::get('/matapelajaran/edit/{id}', 'MataPelajaran@edit_modal')->name('matapelajaranEditModal');
        Route::post('/matapelajaran/update/{id}', 'MataPelajaran@update')->name('matapelajaranUpdate');
    });
});

Route::group(['namespace' => 'Jadwal'], function () {

    Route::group(['middleware' => 'authLogin'], function () {
        Route::get('/jadwal/kelas/{kls}', "Jadwal@index")->name('jadwalList');
        Route::post('/jadwal/get', "Jadwal@ambil")->name('ambilJadwal');
        Route::get('/jadwal/kelas/I', "Jadwal@index")->name('jadwalListI');
        Route::get('/jadwal/kelas/II', "Jadwal@index")->name('jadwalListII');
        Route::get('/jadwal/kelas/III', "Jadwal@index")->name('jadwalListIII');
        Route::get('/jadwal/kelas/IV', "Jadwal@index")->name('jadwalListIV');
        Route::get('/jadwal/kelas/V', "Jadwal@index")->name('jadwalListV');
        Route::get('/jadwal/kelas/VI', "Jadwal@index")->name('jadwalListVI');
        Route::post('/jadwal/update', "Jadwal@update")->name('jadwalUpdate');
        // Route::post('/jadwal/update', "Jadwal@updateOld")->name('jadwalUpdateold');
    });
});

Route::group(['namespace' => 'Guru'], function () {

    Route::group(['middleware' => 'authLogin'], function () {
        Route::get('/guru', "Guru@index")->name('guruList');
        Route::post('/guru/datatable', 'Guru@data_table')->name('guruDataTable');
        Route::get('/guru/create', 'Guru@create')->name('guruCreate');
        Route::post('/guru/insert', "Guru@insert")->name('guruInsert');
        Route::delete('/guru/delete/{id}', "Guru@delete")->name('guruDelete');
        Route::get('/guru/edit/{id}', "Guru@edit_modal")->name('guruEditModal');
        Route::post('/guru/update/{id}', "Guru@update")->name('guruUpdate');
    });
});

Route::group(['namespace' => 'Kelas'], function () {

    Route::group(['middleware' => 'authLogin'], function () {
        Route::get('/kelas', "Kelas@index")->name('kelasList');
        Route::post('/kelas/datatable', 'Kelas@data_table')->name('kelasDataTable');
        Route::get('/kelas/create', 'Kelas@create')->name('kelasCreate');
        Route::post('/kelas/insert', "Kelas@insert")->name('kelasInsert');
        Route::delete('/kelas/delete{id}', "Kelas@delete")->name('kelasDelete');
        Route::get('/kelas/edit/{id}', "Kelas@edit_modal")->name('kelasEditModal');
        Route::post('/kelas/update/{id}', "Kelas@update")->name('kelasUpdate');
    });
});

Route::group(['namespace' => 'Siswa'], function () {

    Route::group(['middleware' => 'authLogin'], function () {
        // Route::get('/siswa', "Siswa@index")->name('siswaList');
        Route::get('siswa/{kls}', "Siswa@index")->name('siswaList');
        // Route::get('/siswa/I', "SiswaI@index")->name('siswaListI');
        // Route::get('/siswa/II', "SiswaII@index")->name('siswaListII');
        // Route::get('/siswa/III', "SiswaIII@index")->name('siswaListIII');
        // Route::get('/siswa/IV', "SiswaIV@index")->name('siswaListIV');
        // Route::get('/siswa/V', "SiswaV@index")->name('siswaListV');
        // Route::get('/siswa/VI', "SiswaVI@index")->name('siswaListVI');
        Route::post('/siswa/datatable', 'Siswa@data_table')->name('siswaDataTable');
        // Route::post('/siswa/I/datatable', 'SiswaI@data_table')->name('siswaDataTable1');
        // Route::post('/siswa/II/datatable', 'SiswaII@data_table')->name('siswaDataTableII');
        // Route::post('/siswa/III/datatable', 'SiswaIII@data_table')->name('siswaDataTableIII');
        // Route::post('/siswa/IV/datatable', 'SiswaIV@data_table')->name('siswaDataTableIV');
        // Route::post('/siswa/V/datatable', 'SiswaV@data_table')->name('siswaDataTableV');
        // Route::post('/siswa/VI/datatable', 'SiswaVI@data_table')->name('siswaDataTableVI');
        Route::get('/siswa/create', 'Siswa@create')->name('siswaCreate');
        // Route::get('/siswa/I/create', 'SiswaI@create')->name('siswaCreateI');
        // Route::get('/siswa/II/create', 'SiswaII@create')->name('siswaCreateII');
        // Route::get('/siswa/III/create', 'SiswaIII@create')->name('siswaCreateIII');
        // Route::get('/siswa/IV/create', 'SiswaIV@create')->name('siswaCreateIV');
        // Route::get('/siswa/V/create', 'SiswaV@create')->name('siswaCreateV');
        // Route::get('/siswa/VI/create', 'SiswaVI@create')->name('siswaCreateVI');
        Route::post('/siswa/insert', "Siswa@insert")->name('siswaInsert');
        // Route::post('/siswa/I/insert', "SiswaI@insert")->name('siswaInsertI');
        // Route::post('/siswa/II/insert', "SiswaII@insert")->name('siswaInsertII');
        // Route::post('/siswa/III/insert', "SiswaIII@insert")->name('siswaInsertIII');
        // Route::post('/siswa/IV/insert', "SiswaIV@insert")->name('siswaInsertIV');
        // Route::post('/siswa/V/insert', "SiswaV@insert")->name('siswaInsertV');
        // Route::post('/siswa/VI/insert', "SiswaVI@insert")->name('siswaInsertVI');
        Route::delete('/siswa/{id}', "Siswa@delete")->name('siswaDelete');
        Route::get('/siswa-edit/{id}', "Siswa@edit_modal")->name('siswaEditModal');
        // Route::get('/siswa/I/{id}', "SiswaI@edit_modal")->name('siswaEditModalI');
        // Route::get('/siswa/II/{id}', "SiswaII@edit_modal")->name('siswaEditModalII');
        // Route::get('/siswa/III/{id}', "SiswaIII@edit_modal")->name('siswaEditModalIII');
        // Route::get('/siswa/IV/{id}', "SiswaIV@edit_modal")->name('siswaEditModalIV');
        // Route::get('/siswa/V/{id}', "SiswaV@edit_modal")->name('siswaEditModalV');
        // Route::get('/siswa/VI/{id}', "SiswaVI@edit_modal")->name('siswaEditModalVI');
        Route::post('/siswa/{id}', "Siswa@update")->name('siswaUpdate');
        // Route::post('/siswa/I/{id}', "SiswaI@update")->name('siswaUpdateI');
        // Route::post('/siswa/II/{id}', "SiswaII@update")->name('siswaUpdateII');
        // Route::post('/siswa/III/{id}', "SiswaIII@update")->name('siswaUpdateIII');
        // Route::post('/siswa/IV/{id}', "SiswaIV@update")->name('siswaUpdateIV');
        // Route::post('/siswa/V/{id}', "SiswaV@update")->name('siswaUpdateV');
        // Route::post('/siswa/VI/{id}', "SiswaVI@update")->name('siswaUpdateVI');
    });
    Route::group(['middleware' => 'authLogin'], function () {
        // Route::get('/siswa', "Siswa@index")->name('siswaList');

        Route::get('/siswa/I', "SiswaI@index")->name('siswaList1');
        Route::get('/siswa/II', "SiswaII@index")->name('siswaListII');
        Route::get('/siswa/III', "SiswaIII@index")->name('siswaListIII');
        Route::get('/siswa/IV', "SiswaIV@index")->name('siswaListIV');
        Route::get('/siswa/V', "SiswaV@index")->name('siswaListV');
        Route::get('/siswa/VI', "SiswaVI@index")->name('siswaListVI');
        // Route::post('/siswa/datatable', 'Siswa@data_table')->name('siswaDataTable');
        Route::post('/siswa/I/datatable', 'SiswaI@data_table')->name('siswaDataTable1');
        Route::post('/siswa/II/datatable', 'SiswaII@data_table')->name('siswaDataTableII');
        Route::post('/siswa/III/datatable', 'SiswaIII@data_table')->name('siswaDataTableIII');
        Route::post('/siswa/IV/datatable', 'SiswaIV@data_table')->name('siswaDataTableIV');
        Route::post('/siswa/V/datatable', 'SiswaV@data_table')->name('siswaDataTableV');
        Route::post('/siswa/VI/datatable', 'SiswaVI@data_table')->name('siswaDataTableVI');
        // Route::get('/siswa/create', 'Siswa@create')->name('siswaCreate');
        Route::get('/siswa/I/create', 'SiswaI@create')->name('siswaCreateI');
        Route::get('/siswa/II/create', 'SiswaII@create')->name('siswaCreateII');
        Route::get('/siswa/III/create', 'SiswaIII@create')->name('siswaCreateIII');
        Route::get('/siswa/IV/create', 'SiswaIV@create')->name('siswaCreateIV');
        Route::get('/siswa/V/create', 'SiswaV@create')->name('siswaCreateV');
        Route::get('/siswa/VI/create', 'SiswaVI@create')->name('siswaCreateVI');
        // Route::post('/siswa/insert', "Siswa@insert")->name('siswaInsert');
        Route::post('/siswa/I/insert', "SiswaI@insert")->name('siswaInsertI');
        Route::post('/siswa/II/insert', "SiswaII@insert")->name('siswaInsertII');
        Route::post('/siswa/III/insert', "SiswaIII@insert")->name('siswaInsertIII');
        Route::post('/siswa/IV/insert', "SiswaIV@insert")->name('siswaInsertIV');
        Route::post('/siswa/V/insert', "SiswaV@insert")->name('siswaInsertV');
        Route::post('/siswa/VI/insert', "SiswaVI@insert")->name('siswaInsertVI');
        Route::delete('/siswa/{id}', "Siswa@delete")->name('siswaDelete');
        // Route::get('/siswa/{id}', "Siswa@edit_modal")->name('siswaEditModal');
        Route::get('/siswa/I/{id}', "SiswaI@edit_modal")->name('siswaEditModalI');
        Route::get('/siswa/II/{id}', "SiswaII@edit_modal")->name('siswaEditModalII');
        Route::get('/siswa/III/{id}', "SiswaIII@edit_modal")->name('siswaEditModalIII');
        Route::get('/siswa/IV/{id}', "SiswaIV@edit_modal")->name('siswaEditModalIV');
        Route::get('/siswa/V/{id}', "SiswaV@edit_modal")->name('siswaEditModalV');
        Route::get('/siswa/VI/{id}', "SiswaVI@edit_modal")->name('siswaEditModalVI');
        // Route::post('/siswa/{id}', "Siswa@update")->name('siswaUpdate');
        Route::post('/siswa/I/{id}', "SiswaI@update")->name('siswaUpdateI');
        Route::post('/siswa/II/{id}', "SiswaII@update")->name('siswaUpdateII');
        Route::post('/siswa/III/{id}', "SiswaIII@update")->name('siswaUpdateIII');
        Route::post('/siswa/IV/{id}', "SiswaIV@update")->name('siswaUpdateIV');
        Route::post('/siswa/V/{id}', "SiswaV@update")->name('siswaUpdateV');
        Route::post('/siswa/VI/{id}', "SiswaVI@update")->name('siswaUpdateVI');
    });
});

Route::group(['namespace' => 'OrangTua'], function () {

    Route::group(['middleware' => 'authLogin'], function () {
        Route::get('/orangtua', "OrangTua@index")->name('orangtuaList');
        Route::post('/orangtua/datatable', 'OrangTua@data_table')->name('orangtuaDataTable');
        Route::get('/orangtua/create', 'OrangTua@create')->name('orangtuaCreate');
        Route::post('/orangtua/insert', "OrangTua@insert")->name('orangtuaInsert');
        Route::delete('/orangtua/{id}', "OrangTua@delete")->name('orangtuaDelete');
        Route::get('/orangtua/{id}', "OrangTua@edit_modal")->name('orangtuaEditModal');
        Route::post('/orangtua/{id}', "OrangTua@update")->name('orangtuaUpdate');
    });
});

Route::group(['namespace' => 'Nilai'], function () {

    Route::group(['middleware' => 'authLogin'], function () {
        Route::delete('/nilai/delete/{id}', "Nilai@delete")->name('nilaiDelete');
        Route::post('/nilai/update/{id}', "Nilai@update")->name('nilaiUpdate');
        Route::get('/nilai/{kls}', "Nilai@index")->name('nilaiList');
        Route::get('/nilai/I', "NilaiI@index")->name('nilaiListI');
        Route::get('/nilai/II', "NilaiII@index")->name('nilaiListII');
        Route::get('/nilai/III', "NilaiIII@index")->name('nilaiListIII');
        Route::get('/nilai/IV', "NilaiIV@index")->name('nilaiListIV');
        Route::get('/nilai/V', "NilaiV@index")->name('nilaiListV');
        Route::get('/nilai/VI', "NilaiVI@index")->name('nilaiListVI');
        Route::post('/nilai/datatable', 'Nilai@data_table')->name('nilaiDataTable');
        Route::post('/nilai/datatable/I', 'NilaiI@data_table')->name('nilaiDataTableI');
        Route::post('/nilai/datatable/II', 'NilaiII@data_table')->name('nilaiDataTableII');
        Route::post('/nilai/datatable/III', 'NilaiIII@data_table')->name('nilaiDataTableIII');
        Route::post('/nilai/datatable/IV', 'NilaiIV@data_table')->name('nilaiDataTableIV');
        Route::post('/nilai/datatable/V', 'NilaiV@data_table')->name('nilaiDataTableV');
        Route::post('/nilai/datatable/VI', 'NilaiVI@data_table')->name('nilaiDataTableVI');
        Route::get('/nilai/create/I', 'NilaiI@create')->name('nilaiCreateI');
        Route::get('/nilai/create/II', 'NilaiII@create')->name('nilaiCreateII');
        Route::get('/nilai/create/III', 'NilaiIII@create')->name('nilaiCreateIII');
        Route::get('/nilai/create/IV', 'NilaiIV@create')->name('nilaiCreateIV');
        Route::get('/nilai/create/V', 'NilaiV@create')->name('nilaiCreateV');
        Route::get('/nilai/create/VI', 'NilaiVI@create')->name('nilaiCreateVI');
        Route::post('/nilai/insert', "Nilai@insert")->name('nilaiInsert');
        Route::get('/nilai/kelas/{id}', "Nilai@edit_modal")->name('nilaiEditModal');
        Route::get('/nilai/I/{id}', "NilaiI@edit_modal")->name('nilaiEditModalI');
        Route::get('/nilai/II/{id}', "NilaiII@edit_modal")->name('nilaiEditModalII');
        Route::get('/nilai/III/{id}', "NilaiIII@edit_modal")->name('nilaiEditModalIII');
        Route::get('/nilai/IV/{id}', "NilaiIV@edit_modal")->name('nilaiEditModalIV');
        Route::get('/nilai/V/{id}', "NilaiV@edit_modal")->name('nilaiEditModalV');
        Route::get('/nilai/VI/{id}', "NilaiVI@edit_modal")->name('nilaiEditModalVI');
    });
});

Route::group(['namespace' => 'Absen'], function () {

    Route::group(['middleware' => 'authLogin'], function () {
        Route::delete('/absen/delete/{id}', "Absen@delete")->name('absenDelete');
        Route::post('/absen/update/{id}', "Absen@update")->name('absenUpdate');
        Route::get('/absen/edit/{id}', "Absen@edit_modal")->name('absenEditModal');
        Route::get('/absen/{kls}', "Absen@index")->name('absenList');
        Route::get('/absen/I', "AbsenI@index")->name('absenListI');
        Route::get('/absen/II', "AbsenII@index")->name('absenListII');
        Route::get('/absen/III', "AbsenIII@index")->name('absenListIII');
        Route::get('/absen/IV', "AbsenIV@index")->name('absenListIV');
        Route::get('/absen/V', "AbsenV@index")->name('absenListV');
        Route::get('/absen/VI', "AbsenVI@index")->name('absenListVI');
        Route::post('/absen/datatable', 'Absen@data_table')->name('absenDataTable');
        Route::post('/absen/datatable/I', 'AbsenI@data_table')->name('absenDataTableI');
        Route::post('/absen/datatable/II', 'AbsenII@data_table')->name('absenDataTableII');
        Route::post('/absen/datatable/III', 'AbsenIII@data_table')->name('absenDataTableIII');
        Route::post('/absen/datatable/IV', 'AbsenIV@data_table')->name('absenDataTableIV');
        Route::post('/absen/datatable/V', 'AbsenV@data_table')->name('absenDataTableV');
        Route::post('/absen/datatable/VI', 'AbsenVI@data_table')->name('absenDataTableVI');
        Route::get('/absen/create', 'Absen@create')->name('absenCreate');
        Route::get('/absen/create/I', 'AbsenI@create')->name('absenCreateI');
        Route::get('/absen/create/II', 'AbsenII@create')->name('absenCreateII');
        Route::get('/absen/create/III', 'AbsenIII@create')->name('absenCreateIII');
        Route::get('/absen/create/IV', 'AbsenIV@create')->name('absenCreateIV');
        Route::get('/absen/create/V', 'AbsenV@create')->name('absenCreateV');
        Route::get('/absen/create/VI', 'AbsenVI@create')->name('absenCreateVI');
        Route::post('/absen/insert', "Absen@insert")->name('absenInsert');
        // Route::post('/absen/insert/I', "AbsenI@insert")->name('absenInsertI');
        Route::get('/absen/II/{id}', "AbsenII@edit_modal")->name('absenEditModalII');
        Route::get('/absen/III/{id}', "AbsenIII@edit_modal")->name('absenEditModalIII');
        Route::get('/absen/IV/{id}', "AbsenIV@edit_modal")->name('absenEditModalIV');
        Route::get('/absen/V/{id}', "AbsenV@edit_modal")->name('absenEditModalV');
        Route::get('/absen/VI/{id}', "AbsenVI@edit_modal")->name('absenEditModalVI');
        // Route::post('/absen/I/{id}', "AbsenI@update")->name('absenUpdateI');

    });
});

Route::group(['namespace' => 'LaporanSiswa'], function () {

    Route::group(['middleware' => 'authLogin'], function () {
        Route::get('/laporansiswa', "LaporanSiswa@index")->name('laporansiswaList');
        Route::post('/laporansiswa/datatable', 'LaporanSiswa@data_table')->name('laporansiswaDataTable');
        Route::get('/laporansiswa/create', 'LaporanSiswa@create')->name('laporansiswaCreate');
        Route::post('/laporansiswa/insert', "LaporanSiswa@insert")->name('laporansiswaInsert');
        Route::delete('/laporansiswa/{id}', "LaporanSiswa@delete")->name('laporansiswaDelete');
        Route::get('/laporansiswa/{id}', "LaporanSiswa@edit_modal")->name('laporansiswaEditModal');
        Route::post('/laporansiswa/{id}', "LaporanSiswa@update")->name('laporansiswaUpdate');
    });
});

Route::group(['namespace' => 'LaporanAnak'], function () {

    Route::group(['middleware' => 'authLogin'], function () {
        Route::get('/laporananak', "LaporanAnak@index")->name('laporananakList');
        Route::post('/laporananak/datatable', 'LaporanAnak@data_table')->name('laporananakDataTable');
        Route::get('/laporananak/create', 'LaporanAnak@create')->name('laporananakCreate');
        Route::post('/laporananak/insert', "LaporanAnak@insert")->name('laporananakInsert');
        Route::delete('/laporananak/{id}', "LaporanAnak@delete")->name('laporananakDelete');
        Route::get('/laporananak/{id}', "LaporanAnak@edit_modal")->name('laporananakEditModal');
        Route::post('/laporananak/{id}', "LaporanAnak@update")->name('laporananakUpdate');
    });
});

Route::namespace('General')->group(function () {

    Route::get('undercosntruction', "Underconstruction@index")->name('underconstructionPage');
    Route::post('city/list', "General@city_list")->name('cityList');
    Route::post('subdistrict/list', "General@subdistrict_list")->name('subdistrictList');

    Route::group(['middleware' => 'checkLogin'], function () {
        Route::get('/', "Login@index")->name("loginPage");
        Route::post('/roles/login', 'Login@roles')->name("rolesLogin");
        Route::post('/login', "Login@do")->name("loginDo");
    });

    Route::group(['middleware' => 'authLogin'], function () {
        Route::get('/dashboard/admin', "DashboardAdmin@index")->name('dashboardadminPage');
        Route::get('/whatsapp-test', "DashboardAdmin@whatsapp_test")->name('whatsappTest');

        Route::get('/dashboard/guru', "DashboardGuru@index")->name('dashboardguruPage');
        Route::get('/whatsapp-test', "DashboardGuru@whatsapp_test")->name('whatsappTest');

        Route::get('/dashboard/kepala-sekolah', "DashboardKepalaSekolah@index")->name('dashboardkepsekPage');
        Route::get('/whatsapp-test', "DashboardKepalaSekolah@whatsapp_test")->name('whatsappTest');

        Route::get('/dashboard/orang-tua', "DashboardOrangTua@index")->name('dashboardortuPage');
        Route::get('/whatsapp-test', "DashboardOrangTua@whatsapp_test")->name('whatsappTest');

        Route::get('/statistikabsensi/siswa', "StatistikAbsensiAnak@index")->name('statistikabsensianakPage');
        Route::get('/statistikabsensi/{kls}', "StatistikAbsensi@index")->name('statistikabsensiPage');
        Route::post('/ambil/statistikabsensi', "StatistikAbsensi@ambilStatistik")->name('ambilStatistik');
        Route::get('/statistikabsensi/I', "StatistikAbsensiI@index")->name('statistikabsensiPageI');
        Route::get('/statistikabsensi/II', "StatistikAbsensiII@index")->name('statistikabsensiPageII');
        Route::get('/statistikabsensi/III', "StatistikAbsensiIII@index")->name('statistikabsensiPageIII');
        Route::get('/statistikabsensi/IV', "StatistikAbsensiIV@index")->name('statistikabsensiPageIV');
        Route::get('/statistikabsensi/V', "StatistikAbsensiV@index")->name('statistikabsensiPageV');
        Route::get('/statistikabsensi/VI', "StatistikAbsensiVI@index")->name('statistikabsensiPageVI');
        
        Route::get('/statistik/nilai/{kls}', "StatistikNilai@index")->name('statistiknilaiPage');
        Route::post('/ambil/statistik/nilai', "StatistikNilai@ambilStatistik")->name('ambilStatistikNilai');
        Route::get('/statistik/nilai/I', "StatistikNilai@index")->name('statistiknilaiPageI');
        Route::get('/statistik/nilai/II', "StatistikNilai@index")->name('statistiknilaiPageII');
        Route::get('/statistik/nilai/III', "StatistikNilai@index")->name('statistiknilaiPageIII');
        Route::get('/statistik/nilai/IV', "StatistikNilai@index")->name('statistiknilaiPageIV');
        Route::get('/statistik/nilai/V', "StatistikNilai@index")->name('statistiknilaiPageV');
        Route::get('/statistik/nilai/VI', "StatistikNilai@index")->name('statistiknilaiPageVI');

        Route::get('/logout', "Logout@do")->name('logoutDo');
        Route::get('/profile', "Profile@index")->name('profilPage');
        Route::post('/profile/administrator', "Profile@update_administrator")->name('profilAdministratorUpdate');

        Route::post('/cetak/pdf', "General@cetak_pdf")->name('cetakPdf');
    });
});

// =============== Master Data =================== //

Route::group(['namespace' => 'MasterData', 'middleware' => 'authLogin'], function () {

    // Karyawan
    Route::get('/karyawan', "Karyawan@index")->name('karyawanPage');
    Route::post('/karyawan', "Karyawan@insert")->name('karyawanInsert');
    Route::get('/karyawan-list', "Karyawan@list")->name('karyawanList');
    Route::delete('/karyawan/{id}', "Karyawan@delete")->name('karyawanDelete');
    Route::get('/karyawan/{id}', "Karyawan@edit_modal")->name('karyawanEditModal');
    Route::post('/karyawan/{id}', "Karyawan@update")->name('karyawanUpdate');

    // User
    Route::get('/user', "User@index")->name('userPage');
    Route::post('/user', "User@insert")->name('userInsert');
    Route::get('/user-list', "User@list")->name('userList');
    Route::delete('/user/{kode}', "User@delete")->name('userDelete');
    Route::get('/user/modal/{kode}', "User@edit_modal")->name('userEditModal');
    Route::post('/user/{kode}', "User@update")->name('userUpdate');

    // Role User
    Route::get('/user-role', "UserRole@index")->name('userRolePage');
    Route::post('/user-role', "UserRole@insert")->name('userRoleInsert');
    Route::delete('/user-role/{id}', "UserRole@delete")->name('userRoleDelete');
    Route::get('/user-role/modal/{id}', "UserRole@edit")->name('userRoleEditModal');
    Route::post('/user-role/{id}', "UserRole@update")->name('userRoleUpdate');
    Route::get('/user-role/akses/{id}', "UserRole@akses")->name('userRoleAkses');
    Route::post('/user-role/akses/{id}', "UserRole@akses_update")->name('userRoleAksesUpdate');

    // Metode Tindakan
    Route::get('/metode-tindakan', "ActionMethod@index")->name('actionMethodPage');
    Route::post('/metode-tindakan', "ActionMethod@insert")->name('actionMethodInsert');
    Route::get('/metode-tindakan-list', "ActionMethod@list")->name('actionMethodList');
    Route::delete('/metode-tindakan/{kode}', "ActionMethod@delete")->name('actionMethodDelete');
    Route::get('/metode-tindakan/modal/{kode}', "ActionMethod@edit_modal")->name('actionMethodEditModal');
    Route::post('/metode-tindakan/{kode}', "ActionMethod@update")->name('actionMethodUpdate');
});

Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');
    //Artisan::call('route:cache');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
    return "Cache is cleared";
});
