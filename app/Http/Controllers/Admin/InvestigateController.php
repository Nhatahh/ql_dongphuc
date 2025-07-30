<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\Check_user;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use PhpOption\Option;
use PhpParser\Node\Expr\FuncCall;
use \App\Http\Controllers\User\Main\InfoUserController;
use \App\Http\Controllers\Admin\YearBatchController;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExportInvestigateController;

use \App\Http\Controllers\User\Main\RegisterWishController;
use Exception;
use LDAP\Result;
use Psy\Command\WhereamiCommand;

use function PHPUnit\Framework\countOf;

class InvestigateController extends Controller

{
    public function index(){
        return view('admin.investigate.index',
        [
            'title' => "CTUT|Hệ thống đăng ký xét tuyển",
        ]);
    }

    public function save_trangthai($id,$trangthai){
        DB::beginTransaction();
        try{
            DB::table('l_go')
            ->where('id_wish',$id)
            ->update(
                [
                    'ghichu' => $trangthai,
                ]
            );

            if($trangthai == 1){
                DB::table('l_go')
                ->where('id_wish',$id)
                ->update(
                    [
                        'block_all' => 0,
                    ]
                );
            }else{
                DB::table('l_go')
                ->where('id_wish',$id)
                ->update(
                    [
                        'block_all' => 1,
                    ]
                );
            }

            switch ($trangthai) {
                case '1':
                    $text = "Nhập học";
                    break;
                case '2':
                    $text = "Không học";
                    break;
                case '3':
                    $text = "Không liên lạc được";
                    break;
                case '0':
                    $text = "Hủy kết quả điều tra";
                    break;
                default:
                    # code...
                    break;
            }
            $user_agent = $_SERVER['HTTP_USER_AGENT'];
            DB::table('l_history')
            ->insert([
                'id_student'    =>  0,
                'id_user'       =>  Auth::user()->id,
                'name_history'  =>  "Điều tra nhập học",
                'content'       =>  'Cập nhật trạng thái nhập học: '.$text,
                'ip'            => request()->ip(),
                'info_client'   => $user_agent
            ]);
            DB::commit();
            echo 1;
        }catch(Exception $e){
            DB::rollBack();
            echo 0;
        }
    }





    public function excel_investigate($major,$seen,$onl,$off,$go,$xnnh){

        if( $major == 0){
            $major = 'AND l_major.id  is not null';
        }else{
            $major = 'AND l_major.id  = '.$major;
        }


        if( $seen == 0){
            $seen  = 'AND l_info_users.id_user is not null';
        }else{
            if($seen == 2)
            {
                $seen = 'AND l_info_users.id_user IN (SELECT DISTINCT(id_user) as id_user FROM l_go_insv)';
            }else{
                $seen = 'AND l_info_users.id_user NOT IN (SELECT DISTINCT(id_user) as id_user FROM l_go_insv)';
            }
        }


        if( $onl == 0){
            $onl  = 'AND l_go_batch_pass.check_end is not null';
        }else{
            if($onl == 2)
            {
                $onl = 'AND l_go_batch_pass.check_end = 1';
            }else{
                $onl = 'AND l_go_batch_pass.check_end = 0';
            }
        }

        if( $off == 0){
            $off  = 'AND l_info_users.id_user is not null';
        }else{
            if($off == 2)
            {
                $off = 'AND l_info_users.id_user  IN (SELECT l_check_assuser.id_student FROM l_check_assuser WHERE check_user = 3)';
            }else{
                $off = 'AND l_info_users.id_user NOT IN (SELECT l_check_assuser.id_student FROM l_check_assuser WHERE check_user = 3)';
            }
        }

        if( $go == 0){
            $go  = 'is not null';
        }else{
            if($go == 2)
            {
                $go = 'IN (SELECT l_go_insv_admin.id_student FROM l_go_insv_admin WHERE l_go_insv_admin.active = 2)';
            }else{
                $go = 'IN (SELECT l_go_insv_admin.id_student FROM l_go_insv_admin WHERE l_go_insv_admin.active = 1)';
            }
        }


        if( $xnnh == 0){
            $xnnh  = 'AND l_info_users.id_user is not null';
        }else{
            if($xnnh == 1)
            {
                $xnnh = 'AND l_go_xanhannhaphoc.id_user is null';
            }else{
                $xnnh = 'AND l_go_xanhannhaphoc.id_user is not null';
            }
        }

        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $title = 'DSTrungTuyenChinhthuc_'.date("d-m-Y H:i:s").'.xlsx';
        return Excel::download(new ExportInvestigateController($major,$seen,$onl,$off,$go,$xnnh),$title);




        //   $a =   [['092205007233','0939685031','vothientrung43@gmail.com'],['092305001331','0896470945','Nguyenthingoctruc.com.vn@gmail.com'],['091305007961','0945407335','buiminhtrich.01012000@gmail.com'],['092205003852','0898035517','mtri291005@gmail.com'],['093205001365','0702825632','nguyenvantoan14122005@gmail.com'],['092205003635','0706770435','null@gmail.com'],['092305011381','0932207546','pnh2023b12minhthithanhthuy@gmail.com'],['095205001530','0944826181','null@gmail.com'],['093305004306','0934569477','haanthuan2401@gmail.com'],['094205006659','0936373891','quocthinhct123@gmail.com'],['092201006202','0704855955','huynhthanhthien0128@gmail.com'],['036205019797','0817342505','xuansontrinhcma@gmail.com'],['092205000422','0842778646','luongshang110505@gmail.com'],['092205000716','0931033638','letansang2803@gmail.com'],['082205013709','0931439524','null@gmail.com'],['093205005450','0943132616','quang4869@gmail.com'],['092205006312','0789606464','doq02832@gmail.com'],['092205002357','0913767712','nqphuc05@gmail.com'],['092205006675','0706502046','nguyenhoangphuc22122005@gmail.com'],['092205005552','0839378205','null@gmail.com'],['093204001290','0786985426','vphat0312@gmail.com'],['093205001640','0522118809','phat34532@gmail.com'],['092205003343','0762944997','ngotanphat2602@gmail.com'],['095305010137','0947435171','huynhnhugunny@gmail.com'],['092205003378','0332347585','trieunhan222@gmail.com'],['086205000096','0932988440','lethanhnhan16032000@gmail.com'],['091205013136','0869148937','lenguyen16042005@icloud.com'],['094205010534','0775890712','nghinguyenoccho@gmail.com'],['086305009884','0979116109','Vokieumy210218@gmail.com'],['092205004160','0774779829','ngothanhloi873@gmail.com'],['094205007562','0352239128','loc242910@gmail.com'],['094205006601','0768854723','tranthanhlockk@gmail.com'],['093205001777','0822522892','ngphucloc0204@gmail.com'],['094203002628','0915732091','buiphuclocst99@gmail.com'],['092305006893','0795823868','tklinh2020_2023@thptankhanh.edu.vn'],['087205002971','0966023902','phamminhkiet20277@laivung2.edu.vn'],['086205005612','0333040242','tuankietkg1212@gmail.com'],['092205003109','0398645949','nguyenquockiet0008@gmail.com'],['092205005309','0766859303','doqkiet.ct2005@icloud.com'],['092205001184','0398754240','trungkien.ct2005@gmail.com'],['095205000794','0915023797','trandangkhoi242@gmail.com'],['094205014896','0388587053','trandangkhoadmx1086@gmail.com'],['094204000217','0923127500','khanhnguyenvlog@gmail.com'],['089205000454','0845465656','kta5908@gmail.com'],['092205003207','0387603611','nghdtgh0504@gmail.com'],['092205002585','0823419112','khangcao2505@gmail.com'],['093305004942','0388212701','huynhthimongkha12102005@gmail.com'],['092205002358','0377792924','hungno1210@gmail.com'],['093204009088','0782484695','lamgiahung230@gmail.com'],['094205008056','0394522794','ngohoanghuypl.2005@gmail.com'],['092205005900','0907994961','pnh2023b6truongquochung@gmail.com'],['092205005059','0917565532','pnh2023b5tranhuyhoang@gmail.com'],['092204002494','0768768849','buinguyentrunghieu399@gmail.com'],['092205012294','0939807794','haungo23102005@gmail.com'],['092205012435','0907352289','giang280205@gmail.com'],['092204004304','0383960753','thinhemlenhut@gmail.com'],['092205002360','0379891205','ddinh6496@gmail.com'],['093205003959','0795940635','lenguyenminhdang0768@gmail.com'],['092204008843','0853204168','pnh2023b12vothanhdat@gmail.com'],['093205005929','0948706016','tdat5313@gmail.com'],['087205002999','0783828956','tranhuudu20268@laivung2.edu.vn'],['092205009257','0867808054','buiphuongdinh.20.3dcn2@gmail.com'],['086305005445','0941863269','nguyendiep150305@gmail.com'],['092205000336','0333910772','daidikhung@gmail.com'],['094205014905','0328595209','vominhchien0812@gmail.com'],['094204002029','0363664966','tranquocbaost2004@gmail.com'],['086305005760','0362136460','dangkimyen22022005@gmail.com'],['095305007951','0948498455','lenhuy2812@gmail.com'],['094305004029','0767292446','phanyenvyg9a1@gmail.com'],['096305001477','0919904058','YeonCy181996@gmail.com'],['094305015506','0772477121','tuongvy2022st@gmail.com'],['082305010136','0774120593','thanhvy13102003@gmail.com'],['091205009662','0347505269','quocvu110421@gmail.com'],['092205004237','0352236240','lychanvi2407@gmail.com'],['094205004164','0838704384','ngov3786@gmail.com'],['092305010421','0939793880','tocattuong0304@gmail.com'],['086305001702','0778180552','tthanhtuyen254@gmail.com'],['094305007944','0338579302','nguyenthithanhtrucst2019@gmail.com'],['096305004221','0942035976','tutrinh171105@gmail.com'],['092305001771','0332214360','tuyettrinh0939996126@gmail.com'],['094305008263','0344410322','huyentrantah@gmail.com'],['089305008151','0866897891','ngoctran210805@gmail.com'],['093305002586','0349656306','nguyentbichtram1465@gmail.com'],['083305003716','0984377387','lengoctram6085@gmail.com'],['094205006973','0924171214','lamphuoctoan2005@gmail.com'],['089305013152','0776591440','tranthikimtien205@gmail.com'],['086305003865','0773541910','thunnie.2005@gmail.com'],['087305000987','0901025707','tranminhthu10042005@gmail.com'],['089304008276','0364853642','athu251124@gmail.com'],['096305010229','0948638652','thu476587@gmail.com'],['093305000666','0367589852','thu40482@gmail.com'],['092205014599','0924418009','thongxamtran@gmail.com'],['092205004389','0779160274','thinhpro2929@gmail.com'],['094205009077','0939815785','ungchithien400@gmail.com'],['087305014091','0908637204','jellyyy836@gmail.com'],['087305015609','0342510461','phamthithuthao030405@gmail.com'],['094205012206','0399398209','lehoangtan1542005@gmail.com'],['094305008551','0988324136','PTHSARA@gmail.com'],['091304008935','0832510137','quynh10jame@gmail.com'],['095305001493','0979642910','quynhquynhh26925@gmail.com'],['092305000569','0795805834','nguyenngocthuyquynh05@gmail.com'],['094305004339','0353274530','vonguyennhaquyen2201@gmail.com'],['094305014472','0825294001','tranhangquyen0408@gmail.com'],['093305007401','0783936574','tothihongquyen@gmail.com'],['086305007538','0325855560','asttquyenha@gmail.com'],['094305009166','0917805332','quinguyen2901@gmail.com'],['092305003289','0707583358','phucdinh684@gmail.com'],['094205000882','0983035348','truongquocphuleona@gmail.com'],['086205005510','0338022453','phanthanhphu041005@gmail.com'],['086205002519','0382443200','nhuanphat145120@gmail.com'],['092305010564','0787967918','phamnhu220805@gmail.com'],['093305001278','0963681184','nhu005102@gmail.com'],['086305001301','0772784665','quynhnhugk1206@gmail.com'],['094305006886','0377445343','huynhnhu301105@gmail.com'],['093305002116','0362414726','huynhthimynhu2005.hgi@gmail.com'],['094305007059','0763850181','duongthilannhu2005tvc@gmail.com'],['092305000154','0342554944','nhungg999000@gmail.com'],['086305008693','0767707533','nhib8201@gmail.com'],['089305023943','0398947039','nhilu7039@gmail.com'],['094305012837','0366182151','letrucxuannguyen@gmail.com'],['092305002872','0774807510','babysociu86@gmail.com'],['094205012745','0334128317','vnghiem557@gmail.com'],['094305003183','0343812961','bichn5169@gmail.com'],['094305008664','0342449080','tungan.8ph@gmail.com'],['094305012778','0374938170','nguenthibichngan@gmail.com'],['094205016226','0329588452','leanhnam2110@gmail.com'],['096306013303','0825555134','nguyenthidiemmy9999101@gmail.com'],['095305005197','0838610325','ngkieumy712@gmail.com'],['084305001356','0395361024','duonghuynhhoangmy@gmail.com'],['096204006771','0837146342','quangminh642004@gmail.com'],['093305003261','0794932059','buithixuanmai0032@gmail.com'],['096305005409','0378936902','tranglua8@gmail.com'],['096304001634','0939868432','thaolinhthkd@gmail.com'],['094305009607','0869893550','nguyenlinhmt81@gmail.com'],['093305004988','0356408564','vantoi1179@gmail.com'],['086204004296','0767500293','phamthanhliem177@gmail.com'],['086204001745','0922124136','vovananhkiet747@gmail.com'],['089205001733','0372616903','khoaanhnguyen060222@gmail.com'],['094204012869','0776579793','lynhatkhoa1505@gmail.com'],['092205007506','0328105910','khanhtruonglyn@gmail.com'],['095205001148','0795961328','longhodt987@gmail.com'],['094205009199','0386926923','khangle82005@gmail.com'],['095205004129','0397768385','hoanghuupham626@gmail.com'],['094305006305','0906957652','vothithuyhuynh1409@gmail.com'],['094305014132','0373756772','mihuien78@gmail.com'],['091205009844','0947261926','N.huy4545@icloud.com'],['094205002693','0355036441','huyminer9947@gmail.com'],['094305008857','0919918183','duhoai285@gmail.com'],['094304008043','0338718441','hn5707902@gmail.com'],['086204009994','0762885502','zxinbahiep@gmail.com'],['086305000850','0375279655','ngochan030805@gmail.com'],['093305010282','0968740912','ntngochan2020_2023@thptankhanh.edu.vn'],['082305013298','0353550659','hanmaingoc70@gmail.com'],['094205004880','0706583918','nguyenhao199901ks@gmail.com'],['086205001665','0399961210','Nguyenhao141125@gmail.com'],['094304009993','0357786214','hanhdinh329@gmail.com'],['093305001280','0778970199','kimhaitranthi2005@gmail.com'],['094305008424','0344197321','huynhgiaoalt123@gmail.com'],['092205001823','0366172290','maie65078@gmail.com'],['094204002768','0366094815','tduoc3715@gmail.com'],['092205001997','0924069747','minhduclx2005@gmail.com'],['096204003810','0849042568','Lehuynhduc.08092004@gmail.com'],['094305005122','0839402133','mahongdao22@gmail.com'],['096305011273','0942705835','ltbd040105@gmail.com'],['086205002047','0327759630','daiquangbui01@gmail.com'],['089305003253','0365641227','phanthithuyduong1227@gmail.com'],['089205022596','0327721233','vodu2462@gmail.com'],['094205010485','0974127151','phunghuudu2019ks@gmail.com'],['093304001030','0779869226','truongthicamduyen2004@gmail.com'],['093305007266','0383188237','duy414231@gmail.com'],['094305004129','0394093672','kimcuong200505@gmail.com'],['095305005160','0912244327','dangtieubang.hp2020@gmail.com'],['092305009338','0939542760','anh.zzz1112@gmail.com'],['092305009607','0795448572','pnh2023b12nguyenthingananh@gmail.com'],['086305001531','0794955090','anthuy151005@gmail.com'],['093305001023','0767951656','hongyenn484@gmail.com'],['083305010444','0367831126','phuongvy472005@gmail.com'],['093305004899','0357832477','nguyenthuyhaivya10.nvh2023@gmail.com'],['092305010431','0907646221','tuonqvyy1204@gmail.com'],['096305010436','0912352730','huynhtuongvy2005cn@gmail.com'],['094305012620','0869676340','thvan2607@gmail.com'],['094205002165','0931075971','theduckoftuong@gmail.com'],['092204015014','0788797848','tn802895@gmail.com'],['092205007175','0919181382','pnh2023b12truongminhtri@gmail.com'],['094305003585','0784375818','duongtram071205@gmail.com'],['091205010706','0918547928','phuoctoan27072005@gmail.com'],['091205007304','0372207040','lehoangtinvthg2020@gmail.com'],['093305007435','0909633054','thanhlehgi@gmail.com'],['092205000560','0374239075','thuankaka172005@gmail.com'],['092205009054','0939328129','thinhthai2005@gmail.com'],['095205001641','0384681534','phanchithien10a4@gmail.com'],['092205002251','0794038190','channelnpt532@gmail.com'],['094305006648','0942941290','anhthi11072005@gmail.com'],['093305006242','0339442257','dinhngoctham89@gmail.com'],['092205000340','0813714123','Lehoangthaidmxcd@gmail.com'],['094205008038','0376703787','taiung2005@gmail.com'],['092205007437','0817973827','ptai73279@gmail.com'],['093305006013','0949663194','nhuhuynhnguyenthi229@gmail.com'],['092205012857','0986969810','vominhquan333@gmail.com'],['089203001807','0353545818','quangkhungday@gmail.com'],['092205004244','0345217331','nvanphuc962@gmail.com'],['092205007454','0788927889','nghongphuc0806@gmail.com'],['092205002485','0799593199','pnh2023b1phuongtanphu@gmail.com'],['094305006626','0859208810','bapxinhgai123@gmail.com'],['092305003657','0707759624','nguyenyennhi54321@gmail.com'],['092305003609','0568973814','tuyetsnhi050905@gmail.com'],['089305007946','0767972989','ngocnhib08@gmail.com'],['095205002710','0948558344','null@gmail.com'],['092205001089','0979915726','minhkhanhnguyen963@gmail.com'],['092305001420','0706699521','pnh2023b5khuugiangoc@gmail.com'],['092305006907','0869976751','thaonganthan78@gmail.com'],['094205001940','0365548272','thachhoainamdtnt2019@gmail.com'],['093305008580','0977090943','xuan1117mai@gmail.com'],['093305007288','0772896891','lyn19126@gmail.com'],['093305000169','0855810702','nguyenkieuloan14092005@gmail.com'],['096205007728','0942269209','truonghoailinhcamau@gmail.com'],['092305008887','0345701146','mariatlinn@gmail.com'],['092305012282','0923219394','legialinh.apr@gmail.com'],['092205005504','0703847205','salllmohamme754@gmail.com'],['093304009910','0335377661','vothininhkieu565@gmail.com'],['092205007765','0327918134','khoicanthocity1903@gmail.com'],['089205002294','0342102847','Khoiho080925@gmail.com'],['086205001838','0349854840','nguyenvukhoavlg@gmail.com'],['092205000819','0836325505','Khoa99958@gmail.com'],['092205005649','0783967718','kimdao01.01.1995@gmail.com'],['087205009819','0923789372','khanhthaypho@gmail.com'],['096205000101','0789695503','pnh2023b9nguyenanduykhanh@gmail.com'],['082205012084','0978058854','huyhoanglop92xhh@gmail.com'],['092205011497','0767170635','pnh2023b11nguyenbaohoang@gmail.com'],['092305003793','0939986265','buivuhan321@gmail.com'],['092205005985','0706331551','nhantiendat2005@gmail.com'],['094205005594','0939815304','letiendat2005tvc@gmail.com'],['086205002532','0779643495','duychonny2712@gmail.com'],['094305001214','0964390545','duy280423@gmail.com'],['092205002763','0775148910','Phamduy2803@gmail.com'],['092205002765','0898420172','duyn21043@gmail.com'],['092205011800','0905389113','ngotranduy205@gmail.com'],['094205008471','0344797072','giacuong364@gmail.com'],['094205007595','0979441580','sonthanhbinhst01@gmail.com'],['092205003744','0767950139','pnh2023b5tranvubang@gmail.com'],['092305004687','0776539163','tua255654@gmail.com'],['093304001624','0358225479','caothieny04@gmail.com'],['094305001138','0377457042','nguyenthinhuy2020ct@gmail.com'],['089305002471','0798942882','nhuy46860@gmail.com'],['094305004116','0362381087','trinhthuyvyks12a3@gmail.com'],['094305001579','0796946205','ngominhthuyvy51@gmail.com'],['096205005027','0942393455','hoangvinh28012005@gmail.com'],['096305004021','0855418841','vothiaivi0405@gmail.com'],['092305012336','0348323190','phamthituongvi205@gmail.com'],['092305006400','0989827249','lamthuyvanct2005@gmail.com'],['092305005114','0979739906','doquyen182005@gmail.com'],['087305016572','0978347824','vtuyet151@gmail.com'],['094305005098','0589083354','285ntuyen@gmail.con'],['093305001583','0839993744','thanhtruc6868kg@gmail.com'],['084305002376','0372041791','thachtrinh19042005@gmail.com'],['086305009093','0862710544','phanthithutrinh2405@gmail.com'],['086305010007','0767315348','ngoctrinhphannguyen511@gmail.com'],['084305009471','0523913800','trinhmai911205@gmail.com'],['094304000467','0372056287','baotran0611204@gmail.com'],['087305004422','0762876016','nguyenthihuyentran2021dt@gmail.com'],['094305000567','0868314213','tran28072005@gmail.com'],['096304005929','0944080629','ngtran184@gmail.com'],['092305005300','0919166541','lengoctran0905@gmail.com'],['079305029981','0377399262','lamhuynhngoctram@gmail.com'],['056305010211','0337938900','thuytranglethi619@gmail.com'],['093205009237','0832966733','daylathanhtoan@gmail.com'],['092205010622','0939438363','tinhnst7@gmail.com'],['089205010011','0931577480','dptienlx247@gmail.com'],['089305018100','0865840313','tientran04112005@gmail.com'],['091305015832','0879282511','42.nguyenthikimtienn11a7@gmail.com']];

//         $a = [
//          ['094305001907','2023.H03.1424'],['092305002140','2023.H03.1425'],['092305008757','2023.H03.1426'],['094305002504','2023.H03.1427'],['094205005468','2023.H03.1428'],['094205004944','2023.H03.1429'],['094305009011','2023.H03.1430'],['091304004436','2023.H03.1431'],['092305003636','2023.H03.1432'],['089305002215','2023.H03.1433'],['094305000622','2023.H03.1434'],['093205001261','2023.H03.1435'],['092205004943','2023.H03.1436'],['093305001321','2023.H03.1437'],['095305006793','2023.H03.1438'],['093304005309','2023.H03.1439'],['086304003453','2023.H03.1440'],['094305001511','2023.H03.1441'],['092305004511','2023.H03.1442'],['094305010674','2023.H03.1443'],['092205002918','2023.H03.1444'],['092305010351','2023.H03.1445'],['094305002581','2023.H03.1446'],['089305002116','2023.H03.1447'],['092205007453','2023.H03.1448'],['092305000302','2023.H03.1449'],['092305008130','2023.H03.1450'],['093205000968','2023.H03.1451'],['091203004088','2023.H03.1452'],['093305002080','2023.H03.1453'],['092305005967','2023.H03.1454'],['096305007487','2023.H03.1455'],['092305006735','2023.H03.1456'],['095305000188','2023.H03.1457'],['094305007650','2023.H03.1458'],['093205001494','2023.H03.1459'],['092305000657','2023.H03.1460'],['084305008043','2023.H03.1461'],['092305009567','2023.H03.1462'],['086205004522','2023.H03.1463'],['089205018220','2023.H03.1464'],['096205010422','2023.H03.1465'],['093305004228','2023.H03.1466'],['086305010930','2023.H03.1467'],['089305021912','2023.H03.1468'],['089305000661','2023.H03.1469'],['095305008034','2023.H03.1470'],['093305005148','2023.H03.1471'],['089305002522','2023.H03.1472'],['094205005715','2023.H03.1473'],['094205006567','2023.H03.1474'],['089305018418','2023.H03.1475'],['089205001043','2023.H03.1476'],['089205021843','2023.H03.1477'],['092305000352','2023.H03.1478'],['092205006162','2023.H03.1479'],['089205008080','2023.H03.1480'],['094304001381','2023.H03.1481'],['094205006522','2023.H03.1482'],['092305003448','2023.H03.1483'],['092305005301','2023.H03.1484'],['092205001205','2023.H03.1485'],['089305002091','2023.H03.1486'],['094205010849','2023.H03.1487'],['089205006274','2023.H03.1488'],['094205001024','2023.H03.1489'],['089205022594','2023.H03.1490'],['094205002672','2023.H03.1491'],['094305007642','2023.H03.1492'],['089204009205','2023.H03.1493'],['089305014760','2023.H03.1494'],['092205003577','2023.H03.1495'],['094205011354','2023.H03.1496'],['092305002905','2023.H03.1497'],['094305001701','2023.H03.1498'],['089305002715','2023.H03.1499'],['094305004419','2023.H04.1500'],['089305001736','2023.H04.1501'],['094304000468','2023.H04.1502'],['093305005134','2023.H04.1503'],['094305001564','2023.H04.1504'],['093305006134','2023.H04.1505'],['091305001655','2023.H04.1506'],['091205001909','2023.H04.1507'],['089305002473','2023.H04.1508'],['087305013553','2023.H04.1509'],['094305001861','2023.H04.1510'],['092305009689','2023.H04.1511'],['092305000432','2023.H04.1512'],['079305030049','2023.H04.1513'],['092305011101','2023.H04.1514'],['096205003671','2023.H04.1515'],['092305003979','2023.H04.1516'],['084205011478','2023.H04.1517'],['092305001802','2023.H04.1518'],['352722305','2023.H04.1519'],['096305006084','2023.H04.1520'],['092305011699','2023.H04.1521'],['092305002271','2023.H04.1522'],['086305009923','2023.H04.1523'],['096205003957','2023.H04.1524'],['086305004411','2023.H04.1525'],['095305000775','2023.H04.1526'],['086305001063','2023.H04.1527'],['091305015832','2023.H04.1528'],['089305018100','2023.H04.1529'],['089205010011','2023.H04.1530'],['092205010622','2023.H04.1531'],['093205009237','2023.H04.1532'],['056305010211','2023.H04.1533'],['079305029981','2023.H04.1534'],['092305005300','2023.H04.1535'],['096304005929','2023.H04.1536'],['094305000567','2023.H04.1537'],['087305004422','2023.H04.1538'],['094304000467','2023.H04.1539'],['084305009471','2023.H04.1540'],['086305010007','2023.H04.1541'],['086305009093','2023.H04.1542'],['084305002376','2023.H04.1543'],['093305001583','2023.H04.1544'],['094305005098','2023.H04.1545'],['087305016572','2023.H04.1546'],['092305005114','2023.H04.1547'],['092305006400','2023.H04.1548'],['092305012336','2023.H04.1549'],['096305004021','2023.H04.1550'],['096205005027','2023.H04.1551'],['094305001579','2023.H04.1552'],['094305004116','2023.H04.1553'],['089305002471','2023.H04.1554'],['094305001138','2023.H04.1555'],['093304001624','2023.H04.1556'],['092305004687','2023.H04.1557'],['092205003744','2023.H04.1558'],['094205007595','2023.H04.1559'],['094205008471','2023.H04.1560'],['092205011800','2023.H04.1561'],['092205002765','2023.H04.1562'],['092205002763','2023.H04.1563'],['094305001214','2023.H04.1564'],['086205002532','2023.H04.1565'],['094205005594','2023.H04.1566'],['092205005985','2023.H04.1567'],['092305003793','2023.H04.1568'],['092205011497','2023.H04.1569'],['082205012084','2023.H04.1570'],['096205000101','2023.H04.1571'],['087205009819','2023.H04.1572'],['092205005649','2023.H04.1573'],['092205000819','2023.H04.1574'],['086205001838','2023.H04.1575'],['089205002294','2023.H04.1576'],['092205007765','2023.H04.1577'],['093304009910','2023.H04.1578'],['092205005504','2023.H04.1579'],['092305012282','2023.H04.1580'],['092305008887','2023.H04.1581'],['096205007728','2023.H04.1582'],['093305000169','2023.H04.1583'],['093305007288','2023.H04.1584'],['093305008580','2023.H04.1585'],['094205001940','2023.H04.1586'],['092305006907','2023.H04.1587'],['092305001420','2023.H04.1588'],['092205001089','2023.H04.1589'],['095205002710','2023.H04.1590'],['089305007946','2023.H04.1591'],['092305003609','2023.H04.1592'],['092305003657','2023.H04.1593'],['094305006626','2023.H04.1594'],['092205002485','2023.H04.1595'],['092205007454','2023.H04.1596'],['092205004244','2023.H04.1597'],['089203001807','2023.H04.1598'],['092205012857','2023.H04.1599'],['093305006013','2023.H04.1600'],['092205007437','2023.H04.1601'],['094205008038','2023.H04.1602'],['092205000340','2023.H04.1603'],['093305006242','2023.H04.1604'],['094305006648','2023.H04.1605'],['092205002251','2023.H04.1606'],['095205001641','2023.H04.1607'],['092205009054','2023.H04.1608'],['092205000560','2023.H04.1609'],['093305007435','2023.H04.1610'],['091205007304','2023.H04.1611'],['091205010706','2023.H04.1612'],['094305003585','2023.H04.1613'],['092205007175','2023.H04.1614'],['092204015014','2023.H04.1615'],['094205002165','2023.H04.1616'],['094305012620','2023.H04.1617'],['096305010436','2023.H04.1618'],['092305010431','2023.H04.1619'],['093305004899','2023.H04.1620'],['083305010444','2023.H04.1621'],['093305001023','2023.H04.1622'],['086305001531','2023.H04.1623'],['092305009607','2023.H04.1624'],['092305009338','2023.H04.1625'],['095305005160','2023.H04.1626'],['094305004129','2023.H04.1627'],['093305007266','2023.H04.1628'],['093304001030','2023.H04.1629'],['094205010485','2023.H04.1630'],['089205022596','2023.H04.1631'],['089305003253','2023.H04.1632'],['086205002047','2023.H04.1633'],['096305011273','2023.H04.1634'],['094305005122','2023.H04.1635'],['096204003810','2023.H04.1636'],['092205001997','2023.H04.1637'],['094204002768','2023.H04.1638'],['092205001823','2023.H04.1639'],['094305008424','2023.H04.1640'],['093305001280','2023.H04.1641'],['094304009993','2023.H04.1642'],['086205001665','2023.H04.1643'],['094205004880','2023.H04.1644'],['082305013298','2023.H04.1645'],['093305010282','2023.H04.1646'],['086305000850','2023.H04.1647'],['086204009994','2023.H04.1648'],['094304008043','2023.H04.1649'],['094305008857','2023.H04.1650'],['094205002693','2023.H04.1651'],['091205009844','2023.H04.1652'],['094305014132','2023.H04.1653'],['094305006305','2023.H04.1654'],['095205004129','2023.H04.1655'],['094205009199','2023.H04.1656'],['095205001148','2023.H04.1657'],['092205007506','2023.H04.1658'],['094204012869','2023.H04.1659'],['089205001733','2023.H04.1660'],['086204001745','2023.H04.1661'],['086204004296','2023.H04.1662'],['093305004988','2023.H04.1663'],['094305009607','2023.H04.1664'],['096304001634','2023.H04.1665'],['096305005409','2023.H04.1666'],['093305003261','2023.H04.1667'],['096204006771','2023.H04.1668'],['084305001356','2023.H04.1669'],['095305005197','2023.H04.1670'],['096306013303','2023.H04.1671'],['094205016226','2023.H04.1672'],['094305012778','2023.H04.1673'],['094305008664','2023.H04.1674'],['094305003183','2023.H04.1675'],['094205012745','2023.H04.1676'],['092305002872','2023.H04.1677'],['094305012837','2023.H04.1678'],['089305023943','2023.H04.1679'],['086305008693','2023.H04.1680'],['092305000154','2023.H04.1681'],['094305007059','2023.H04.1682'],['093305002116','2023.H04.1683'],['094305006886','2023.H04.1684'],['086305001301','2023.H04.1685'],['093305001278','2023.H04.1686'],['092305010564','2023.H04.1687'],['086205002519','2023.H04.1688'],['086205005510','2023.H04.1689'],['094205000882','2023.H04.1690'],['092305003289','2023.H04.1691'],['094305009166','2023.H04.1692'],['086305007538','2023.H04.1693'],['093305007401','2023.H04.1694'],['094305014472','2023.H04.1695'],['094305004339','2023.H04.1696'],['092305000569','2023.H04.1697'],['095305001493','2023.H04.1698'],['091304008935','2023.H04.1699'],['094305008551','2023.H04.1700'],['094205012206','2023.H04.1701'],['087305015609','2023.H04.1702'],['087305014091','2023.H04.1703'],['094205009077','2023.H04.1704'],['092205004389','2023.H04.1705'],['092205014599','2023.H04.1706'],['093305000666','2023.H04.1707'],['096305010229','2023.H04.1708'],['089304008276','2023.H04.1709'],['087305000987','2023.H04.1710'],['086305003865','2023.H04.1711'],['089305013152','2023.H04.1712'],['094205006973','2023.H04.1713'],['083305003716','2023.H04.1714'],['093305002586','2023.H04.1715'],['089305008151','2023.H04.1716'],['094305008263','2023.H04.1717'],['092305001771','2023.H04.1718'],['096305004221','2023.H04.1719'],['094305007944','2023.H04.1720'],['086305001702','2023.H04.1721'],['092305010421','2023.H04.1722'],['094205004164','2023.H04.1723'],['092205004237','2023.H04.1724'],['091205009662','2023.H04.1725'],['082305010136','2023.H04.1726'],['094305015506','2023.H04.1727'],['096305001477','2023.H04.1728'],['094305004029','2023.H04.1729'],['095305007951','2023.H04.1730'],['086305005760','2023.H04.1731'],['094204002029','2023.H04.1732'],['094205014905','2023.H04.1733'],['092205000336','2023.H04.1734'],['086305005445','2023.H04.1735'],['092205009257','2023.H04.1736'],['087205002999','2023.H04.1737'],['093205005929','2023.H04.1738'],['092204008843','2023.H04.1739'],['093205003959','2023.H04.1740'],['092205002360','2023.H04.1741'],['092204004304','2023.H04.1742'],['092205012435','2023.H04.1743'],['092205012294','2023.H04.1744'],['092204002494','2023.H04.1745'],['092205005059','2023.H04.1746'],['092205005900','2023.H04.1747'],['094205008056','2023.H04.1748'],['093204009088','2023.H04.1749'],['092205002358','2023.H04.1750'],['093305004942','2023.H04.1751'],['092205002585','2023.H04.1752'],['092205003207','2023.H04.1753'],['089205000454','2023.H04.1754'],['094204000217','2023.H04.1755'],['094205014896','2023.H04.1756'],['095205000794','2023.H04.1757'],['092205001184','2023.H04.1758'],['092205005309','2023.H04.1759'],['092205003109','2023.H04.1760'],['086205005612','2023.H04.1761'],['087205002971','2023.H04.1762'],['092305006893','2023.H04.1763'],['094203002628','2023.H04.1764'],['093205001777','2023.H04.1765'],['094205006601','2023.H04.1766'],['094205007562','2023.H04.1767'],['092205004160','2023.H04.1768'],['086305009884','2023.H04.1769'],['094205010534','2023.H04.1770'],['091205013136','2023.H04.1771'],['086205000096','2023.H04.1772'],['092205003378','2023.H04.1773'],['095305010137','2023.H04.1774'],['092205003343','2023.H04.1775'],['093205001640','2023.H04.1776'],['093204001290','2023.H04.1777'],['092205005552','2023.H04.1778'],['092205006675','2023.H04.1779'],['092205002357','2023.H04.1780'],['092205006312','2023.H04.1781'],['093205005450','2023.H04.1782'],['082205013709','2023.H04.1783'],['092205000716','2023.H04.1784'],['092205000422','2023.H04.1785'],['036205019797','2023.H04.1786'],['092201006202','2023.H04.1787'],['094205006659','2023.H04.1788'],['093305004306','2023.H04.1789'],['095205001530','2023.H04.1790'],['092305011381','2023.H04.1791'],['092205003635','2023.H04.1792'],['093205001365','2023.H04.1793'],['092205003852','2023.H04.1794'],['091305007961','2023.H04.1795'],['092305001331','2023.H04.1796'],['092205007233','2023.H04.1797']

//              ];
//         // DB::table('l_info_users')
//         //     ->where('id_user', 5207)
//         //     ->update(
//         //         [
//         //             'maphieu' => '2023.H01.0001',
//         //         ]
//         //         );

//             foreach ($a as $key => $value) {
//                 $b= DB::table('l_users')
//                 ->where('id_batch',2)
//                 ->where('id_card_users', $value[0])
//                 ->get();
//                 DB::table('l_info_users')
//                 ->where('id_user',$b[0]->id)
//                 ->update(
//                     [
//                         'maphieu' => $value[1],
//                     ]
//                     );

//             }

    }

    //Load Search
    public function load_search(){
        //Batch
        $batch0 = new Collection(
            [
                'id' => 0,
                'text' =>"Chọn Đợt tuyển sinh",
                'selected' => true
            ]
        );
        $batchs = DB::table('l_batch')
        ->select('id','name_batch as text')
        ->get();
        $batchs[] = $batch0;


        $result = array(
            'batch' => $batchs,
        );
        return $result;
    }

    public function change_batch($id_batch){
        $major0 = new Collection(
            [
                'id' => 0,
                'text' =>"Ngành tuyển sinh",
                'selected' => true
            ]
        );
        $major_method = DB::select('SELECT l_major.id as id,l_major.name_major as text FROM l_year_batch INNER JOIN l_batch_method ON l_year_batch.id = l_batch_method.id_batch INNER JOIN l_method_major ON l_batch_method.id = l_method_major.id_method INNER JOIN l_major ON l_major.id = l_method_major.id_major GROUP BY l_major.id');
        $major_method[] = $major0;
        return $major_method;
    }

    public function list_investigate(Request $request){
        $major = $request ->input('data')[0];
        $seen = $request ->input('data')[1];
        $onl = $request ->input('data')[2];
        $off = $request ->input('data')[3];
        $go = $request ->input('data')[4];
        $xnnh = $request ->input('data')[5];


        if( $major == 0){
            $major = 'AND l_major.id  is not null';
        }else{
            $major = 'AND l_major.id  = '.$major;
        }


        if( $seen == 0){
            $seen  = '';
        }else{
            if($seen == 2)
            {
                $seen = 'AND l_info_users.id_user IN (SELECT DISTINCT(id_user) as id_user FROM l_go_insv)';
            }else{
                $seen = 'AND l_info_users.id_user NOT IN (SELECT DISTINCT(id_user) as id_user FROM l_go_insv)';
            }
        }


        if( $onl == 0){
            $onl  = 'AND l_go_batch_pass.check_end is not null';
        }else{
            if($onl == 2)
            {
                $onl = 'AND l_go_batch_pass.check_end = 1';
            }else{
                $onl = 'AND l_go_batch_pass.check_end = 0';
            }
        }

        if( $off == 0){
            $off  = '';
        }else{
            if($off == 2)
            {
                $off = 'AND l_info_users.id_user  IN (SELECT l_check_assuser.id_student FROM l_check_assuser WHERE check_user = 3)';
            }else{
                $off = 'AND l_info_users.id_user NOT IN (SELECT l_check_assuser.id_student FROM l_check_assuser WHERE check_user = 3)';
            }
        }

        if( $go == 0){
            $go  = 'is not null';
        }else{
            if($go == 2)
            {
                $go = 'IN (SELECT l_go_insv_admin.id_student FROM l_go_insv_admin WHERE l_go_insv_admin.active = 2)';
            }else{
                $go = 'IN (SELECT l_go_insv_admin.id_student FROM l_go_insv_admin WHERE l_go_insv_admin.active = 1)';
            }
        }

        if( $xnnh == 0){
            $xnnh  = 'AND l_info_users.id_user is not null';
        }else{
            if($xnnh == 1)
            {
                $xnnh = 'AND l_go_xanhannhaphoc.id_user is null';
            }else{
                $xnnh = 'AND l_go_xanhannhaphoc.id_user is not null';
            }
        }


        $sql ='SELECT if(l_go_xanhannhaphoc.id_user is null,0,1) as check_bo, CONCAT(if(PASS.check_user = 3,1,0),"-",if(l_go_insv_admin.note is null,"",l_go_insv_admin.note),"-",l_info_users.id_user) as note, CONCAT(if(PASS.check_user = 3,1,0),"-",if(l_go_insv_admin.active is null,0,l_go_insv_admin.active),"-",l_info_users.id_user) as active, if(PASS.check_user = 3,1,0) as check_user, l_info_users.name_user, l_users.id as id_user, if(INSV.id_ins is null,"0","1") as id_ins, l_users.id_card_users, l_users.phone_users, l_users.email_users,TT.name_major,if(TT.check_end = 1,"1","0") as check_end FROM l_info_users INNER JOIN l_users ON l_users.id = l_info_users.id_user INNER JOIN (SELECT l_wish.id_user, l_major.id, l_major.name_major, l_go_batch_pass.check_end FROM l_go_batch_pass INNER JOIN l_wish ON l_go_batch_pass.id_wish = l_wish.id INNER JOIN l_method_major ON l_method_major.id = l_wish.id_major INNER JOIN l_major ON l_major.id = l_method_major.id_major WHERE  l_go_batch_pass.id_batch IN (SELECT l_year_active.id_batch_locao FROM l_year_active) '.$onl.' AND pass_bo = 1 '.$major.' ) AS TT ON TT.id_user = l_info_users.id_user LEFT JOIN (SELECT DISTINCT(id_user) as id_ins FROM l_go_insv)  AS INSV ON INSV.id_ins = l_info_users.id_user LEFT JOIN (SELECT * FROM l_check_assuser WHERE check_user = 3) AS PASS ON l_info_users.id_user = PASS.id_student LEFT JOIN l_go_insv_admin ON l_go_insv_admin.id_student = l_info_users.id_user LEFT JOIN l_go_xanhannhaphoc ON l_go_xanhannhaphoc.id_user = l_info_users.id_user WHERE l_info_users.id_user '.$go.' '.$seen.' '.$off.' '.$xnnh;
        // $sql ='SELECT l_go.batch as batch,l_wish.id_major, CONCAT(l_go.ghichu,"-",l_go.id_wish) as ghichu,l_wish.id_user as id_user, l_info_users.name_user as name_user,l_info_users.phonesc_user as phonesc_user, if(l_go_check.id_wish is null, "",l_go_check.id_wish) as id_wish, if(l_go_check.id_wish is null,0,1) as active, l_batch.name_batch as name_batch,l_major.name_major as name_major,l_users.id_card_users as id_card_users, l_users.phone_users as phone_users, l_users.email_users as email_users FROM `l_go` LEFT JOIN l_go_check ON l_go_check.id_wish = l_go.id_wish INNER JOIN l_wish ON l_wish.id = l_go.id_wish INNER JOIN l_info_users ON l_info_users.id_user = l_wish.id_user INNER JOIN l_year_batch ON l_year_batch.id = l_wish.id_batch INNER JOIN l_batch ON l_batch.id = l_year_batch.id_batch INNER JOIN l_method_major ON l_method_major.id = l_wish.id_major INNER JOIN l_major ON l_method_major.id_major = l_major.id INNER JOIN l_users ON l_users.id = l_wish.id_user WHERE l_year_batch.id = '.$batch.' AND '.$id_card.' AND '.$phone.' AND '.$id.' AND '.$major.' AND '.$name.' AND '.$check;

                // $sql ="SELECT if(l_check_assuser.pass >0,l_check_assuser.pass,0) as pass,l_check_assuser.id_student as id, l_info_users.name_user as name_user,l_users.phone_users as phone_users,l_users.id_card_users as id_card_users, l_users.email_users as email_users, l_batch.name_batch as name_batch, CONCAT(l_check_assuser.check_user,'-',l_check_assuser.id_student) as check_user FROM l_check_assuser INNER JOIN l_info_users ON l_info_users.id_user = l_check_assuser.id_student INNER JOIN l_users  ON l_users.id = l_check_assuser.id_student INNER JOIN l_batch ON l_batch.id = l_users.id_batch WHERE l_users.id_year = ".$year." AND ".$batch." AND ".$id_card." AND ".$phone." AND ".$id. " AND ".$user." ORDER BY l_check_assuser.create_at ASC";
                // $sql ='SELECT *,l_batch_user.id_user as id FROM `l_batch_user` INNER JOIN l_users ON l_users.id = l_batch_user.id_user INNER JOIN l_info_users ON l_info_users.id_user = l_batch_user.id_user INNER JOIN l_batch ON l_batch.id = l_batch_user.id_batch INNER JOIN l_year_batch ON l_year_batch.id_batch = l_batch_user.id_batch INNER JOIN l_years ON l_years.id = l_year_batch.id_year =  '.$year.' AND '.$batch.' AND '.$id_card.' AND '.$phone.' AND '.$id. ' ORDER BY l_batch_user.id_user ASC';

        $infor = DB::select($sql);
        $json_data['data'] = $infor;
        $data = json_encode($json_data);
        echo  $data;
    }

    public function search($id){
        $infor = DB::table('l_info_users')
        ->join('l_users','l_users.id','l_info_users.id_user')
        ->where('id_user',$id)
        ->get();
        if(count($infor) == 0){
            $active_info = 0;
        }else{
            $active_info = 1;
        }

        $img = DB::table('l_image_hocba')
        ->where('id_user',$id)
        ->where('id_img',10)
        ->get();

        if(count($img) == 0){
            $img = "#";
        }else{
            $img = $img[0]->link_img;
        }

        $result = array(
            'info' => $infor,
            'active_info' => $active_info,
            'img' => $img,
        );
        return $result;
    }

    function check_quanlynganh($id_student){
        $check = DB::select('SELECT l_user_major.id_user as id_user FROM l_wish INNER JOIN l_go_batch_pass ON l_go_batch_pass.id_wish = l_wish.id INNER JOIN l_user_major ON l_user_major.id_major = l_wish.id_major WHERE l_wish.id_user = '.$id_student.' AND pass_bo = 1  AND l_go_batch_pass.id_batch IN (SELECT l_year_active.id_batch_locao FROM l_year_active)');
        if(count($check) >0){
            if($check[0]->id_user == Auth::user()->id){
                return 1; //Không phải giảng viên phân coogn ngành
            }else{
                return 0;
            }
        }else{
            return 0;
        }
    }

    function check_chekend($id_student){
        $check = DB::select('SELECT check_user FROM l_check_assuser WHERE l_check_assuser.id_student = '.$id_student.' AND check_user = 3');
        if(count($check) >0){
            return 1; //Đã xacsd nhận tại Trường

        }else{
            return 0;
        }
    }

    public function insv_active_admin(Request $request){
        $id_student = (int)$request ->input('id_user');
        if($this->check_chekend($id_student) == 1){
            return 4;
        }else{
            if($this->check_quanlynganh($id_student) == 1){
                DB::beginTransaction();
                try{
                    $value = (int)$request ->input('value');
                    $ins = DB::table('l_go_insv_admin')
                    ->updateOrInsert(
                        [
                            'id_student' =>  $id_student,
                        ],
                        [
                            'active' => $value,
                            'id_user' =>  Auth::user()->id,
                        ]
                    );
                    if($ins == 1){
                        if($value = 1){
                            $ac = "Sẽ nhập học";
                        } else{
                            if($value = 2){
                                $ac = "Không nhập học";
                            }else{
                                $ac = "Reset trạng thái";
                            }
                        };
                        $user_agent = $_SERVER['HTTP_USER_AGENT'];
                        DB::table('l_history')
                        ->insert([
                            'id_student'    =>  $id_student,
                            'id_user'       =>  Auth::user()->id,
                            'name_history'  =>  "Điều tra nhập học",
                            'content'       =>  "Cập nhật Trạng thái điều tra: ".$ac,
                            'ip'            => request()->ip(),
                            'info_client'   => $user_agent
                        ]);
                    }
                    DB::commit();
                    return $ins;
                }catch(Exception $e){
                    DB::rollBack();
                    return 2; // Có lõi xảy ra
                }
            }else{
                return 3;
            }
        }

    }

    public function insv_note_admin(Request $request){
        $id_student = (int)$request ->input('id_user');
        if($this->check_chekend($id_student) == 1){
            return 4;
        }else{
            if($this->check_quanlynganh($id_student) == 1){
                DB::beginTransaction();
                try{
                    $value = $request ->input('value');
                    $ins = DB::table('l_go_insv_admin')
                    ->updateOrInsert(
                        [
                            'id_student' =>  $id_student,
                        ],
                        [
                            'note' => $value,
                            'id_user' =>  Auth::user()->id,
                        ]
                    );
                    if($ins == 1){
                        $user_agent = $_SERVER['HTTP_USER_AGENT'];
                        DB::table('l_history')
                        ->insert([
                            'id_student'    =>  $id_student,
                            'id_user'       =>  Auth::user()->id,
                            'name_history'  =>  "Điều tra nhập học",
                            'content'       =>  "Cập nhật ghi chú điều tra: ".$value,
                            'ip'            => request()->ip(),
                            'info_client'   => $user_agent
                        ]);
                    }
                    DB::commit();
                    return $ins;
                }catch(Exception $e){
                    DB::rollBack();
                    return 2; // Có lõi xảy ra
                }
            }else{
                return 3;
            }
        }
    }

    function join($id,$arrs){
        $count = 0;
        foreach ($arrs as $arr) {
            if($id == $arr ->id){
                $val = $arr ->val;
                $count ++;
                break;
                }
        }
        if ($count == 0){
            $val = 0;
        }
        $count = 0;
        return $val;
    }

    public function insv_chart_admin($id_batch){
        $major_method = DB::select('SELECT l_major.id as id, l_major.name_major FROM l_method_major INNER JOIN l_major ON l_major.id = l_method_major.id_major GROUP BY l_major.id');
        $min_major =  DB::select('SELECT l_major.id as id, SUM(l_go_setup.min_major) as val FROM l_method_major INNER JOIN l_go_setup ON l_go_setup.id_major = l_method_major.id INNER JOIN l_major ON l_major.id = l_method_major.id_major WHERE l_go_setup.id_batch = '.$id_batch.' GROUP BY l_major.id');
        $trungtuyen =  DB::select('SELECT l_major.id, COUNT(*) as val FROM l_go_batch_pass INNER JOIN l_wish ON l_wish.id = l_go_batch_pass.id_wish INNER JOIN l_method_major ON l_method_major.id = l_wish.id_major INNER JOIN l_major ON l_method_major.id_major = l_major.id WHERE l_go_batch_pass.id_batch IN (SELECT l_year_active.id_batch_locao FROM l_year_active) AND pass_bo = 1 GROUP BY l_major.id');
        $online =  DB::select('SELECT l_major.id, COUNT(*) as val FROM l_go_batch_pass INNER JOIN l_wish ON l_wish.id = l_go_batch_pass.id_wish INNER JOIN l_method_major ON l_method_major.id = l_wish.id_major INNER JOIN l_major ON l_method_major.id_major = l_major.id WHERE l_go_batch_pass.id_batch IN (SELECT l_year_active.id_batch_locao FROM l_year_active) AND pass_bo = 1 AND check_end = 1 GROUP BY l_major.id');
        $offline =  DB::select('SELECT l_major.id, COUNT(*) as val FROM l_go_batch_pass INNER JOIN l_wish ON l_wish.id = l_go_batch_pass.id_wish INNER JOIN l_method_major ON l_method_major.id = l_wish.id_major INNER JOIN l_major ON l_method_major.id_major = l_major.id INNER JOIN l_check_assuser ON l_check_assuser.id_student = l_wish.id_user WHERE l_check_assuser.check_user = 3 AND l_go_batch_pass.id_batch IN (SELECT l_year_active.id_batch_locao FROM l_year_active) AND pass_bo = 1 GROUP BY l_major.id');

        $bo =  DB::select('SELECT l_major.id, COUNT(*) as val FROM l_go_batch_pass INNER JOIN l_wish ON l_wish.id = l_go_batch_pass.id_wish INNER JOIN l_method_major ON l_method_major.id = l_wish.id_major INNER JOIN l_major ON l_method_major.id_major = l_major.id INNER JOIN l_go_xanhannhaphoc ON l_go_xanhannhaphoc.id_user = l_wish.id_user  WHERE l_go_batch_pass.id_batch IN (SELECT l_year_active.id_batch_locao FROM l_year_active) AND pass_bo = 1 GROUP BY l_major.id ');

        foreach ($major_method as $value) {
            $data[] = array(
                'id' =>$value ->id,
                'name_major' => $value ->name_major,
                'chitieu' =>$this ->join($value ->id,$min_major),
                'trungtuyen' =>$this ->join($value ->id,$trungtuyen),
                'offline' =>$this ->join($value ->id,$offline),
                'online' =>$this ->join($value ->id,$online),
                'bo' =>$this ->join($value ->id,$bo),
            );

        }
        return $data;
    }

}
