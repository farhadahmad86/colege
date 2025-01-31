<?php

namespace App\Http\Controllers;

use App\Models\College\MarkTeacherAttendanceModel;
use App\Models\RegisterDevice;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Rats\Zkteco\Lib\ZKTeco;
use Exception;
use Session;

class MachineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function device_ip()
    {
        $devices = RegisterDevice::where('status', '=', 1)->get();

        return $devices;
    }

    public function device_setip(Request $request)
    {
        $reg = new RegisterDevice();
        $reg->ip_address = $request->deviceip;
        $reg->port = $request->port;
        $reg->save();
        return redirect()->back();
    }

    public function index()
    {

        $not_found = Session::get('port');
        $not_found_ip = Session::get('ip');
        Session::forget('port');
        Session::forget('ip');
        $devices = $this->device_ip();

        return view('zkteco/welcome', compact('devices', 'not_found', 'not_found_ip'));
    }

    public function test_sound()
    {
        $devices = $this->device_ip();
        foreach ($devices as $info) {
            $zk = new ZKTeco($info->ip_address, $info->port);

//            try {
                $zk->connect();
                $zk->disableDevice();
                $zk->testVoice();

//            } catch (Exception $e) {
////                $e->getMessage();
//            }
        }
        return redirect()->route('machine.home')->with('success_message', 'Playing sound on device.');
    }

    public function device_information()
    {
        $devices = $this->device_ip();
        $device = [];
        foreach ($devices as $ip) {
            $zk = new ZKTeco($ip->ip_address, $ip->port);
            try {
                $zk->connect();
                $zk->disableDevice();
                $deviceVersion = $zk->version();
                $deviceOSVersion = $zk->osVersion();
                $devicePlatform = $zk->platform();
                $devicefmVersion = $zk->fmVersion();
                $deviceworkCode = $zk->workCode();
                $devicessr = $zk->ssr();
                $devicepinWidth = $zk->pinWidth();
                $deviceserialNumber = $zk->serialNumber();
                $devicedeviceName = $zk->deviceName();
                $devicegetTime = $zk->getTime();
                $device[] = [
                    'deviceip' => $ip->ip_address,
                    'port' => $ip->port,
                    'deviceVersion' => $deviceVersion,
                    'deviceOSVersion' => $deviceOSVersion,
                    'devicePlatform' => $devicePlatform,
                    'devicefmVersion' => $devicefmVersion,
                    'deviceworkCode' => $deviceworkCode,
                    'devicessr' => $devicessr,
                    'devicepinWidth' => $devicepinWidth,
                    'deviceserialNumber' => $deviceserialNumber,
                    'devicedeviceName' => $devicedeviceName,
                    'devicegetTime' => $devicegetTime,
                ];
            } catch (Exception $e) {
                $e->getMessage();
            }
        }

        return view('zkteco/device-information', compact(
            'device'
        ));
    }

    public function device_data()
    {
        $devices = $this->device_ip();
        $device_data = [];
        foreach ($devices as $ip) {
            $zk = new ZKTeco($ip->ip_address, $ip->port);
            try {
                $zk->connect();
                $zk->disableDevice();
                $users = $zk->getUser();
                $attendaces = $zk->getAttendance();
                $device_data[] = [
                    'deviceip' => $ip->ip_address,
                    'port' => $ip->port,
                    'attendaces' => $attendaces,
                    'users' => $users,
                ];
            } catch (Exception $e) {
                $e->getMessage();
            }
        }

        return view('zkteco/device-data', compact('device_data'));
//        return view('device-data', compact('deviceip', 'users', 'attendaces'));
    }

    public function device_data_clear_attendance()
    {
        $devices = $this->device_ip();
        foreach ($devices as $ip) {
            $zk = new ZKTeco($ip->ip_address, $ip->port);
            try {
                $zk->connect();
                $zk->disableDevice();
                $zk->clearAttendance();
            } catch (Exception $e) {
                $e->getMessage();
            }
        }
        return redirect()->back()->with('success_message', 'Attendance cleared successfully.');
    }

    public function device_restart()
    {
        $devices = $this->device_ip();

        foreach ($devices as $ip) {
            $zk = new ZKTeco($ip->ip_address, $ip->port);
            try {
                $zk->connect();
                $zk->disableDevice();
                $zk->restart();
            } catch (Exception $e) {
                $e->getMessage();
            }
        }
        return redirect()->back()->with('success_message', 'Device restart successfully.');
    }

    public function device_shutdown()
    {
        $devices = $this->device_ip();
        foreach ($devices as $ip) {
            $zk = new ZKTeco($ip->ip_address, $ip->port);
            try {
                $zk->connect();
                $zk->disableDevice();
                $zk->shutdown();
            } catch (Exception $e) {
                $e->getMessage();
            }
        }
        return redirect()->back();
    }

    public function device_adduser()
    {
        $deviceip = $this->device_ip();

        return view('zkteco/device-adduser', compact('deviceip'));
    }

    public function device_setuser(Request $request)
    {
        $devices = $this->device_ip();
        $uid = $request->uid;
        $userid = $request->userid;
        $name = $request->name;
        $role = (int)$request->role;
        $password = $request->password;
        $cardno = $request->cardno;
        foreach ($devices as $ip) {

            $zk = new ZKTeco($ip->ip_address, $ip->port);
            try {
                $zk->connect();
                $zk->disableDevice();
                $zk->setUser($uid, $userid, $name, $role, $password, $cardno);
            } catch (Exception $e) {
                $e->getMessage();
            }
        }
        return redirect()->back()->with('success_message', 'User added to device successfully.');
    }

    public function device_removeuser_single($uid)
    {
        $devices = $this->device_ip();

        foreach ($devices as $ip) {
            $zk = new ZKTeco($ip->ip_address, $ip->port);
            try {
                $zk->connect();
                $zk->disableDevice();
                $zk->removeUser($uid);
            } catch (Exception $e) {
                $e->getMessage();
            }
        }

        return redirect()->back()->with('success_message', 'User removed from device successfully.');
    }

    public function device_viewuser_single(Request $request)
    {
        $deviceips = $this->device_ip();
        $uid = $request->uid;
        $userid = $request->userid;
        $name = $request->name;
        $role = (int)$request->role;
        $password = $request->password;
        $cardno = $request->cardno;

        $zk = new ZKTeco($deviceips[0], $deviceips[1]);
        $zk->connect();
        $userfingerprints = $zk->getFingerprint($request->uid);

        // foreach($userfingerprints as $userfingerprint)
        // {
        //     $imagearray= unpack("C*",$userfingerprint);
        // }
        // $data = implode('', array_map(function($e) {
        //     return pack("C*", $e);
        // }, $$userfingerprint));
        // echo $data;
        return view('zkteco/device-information-user', compact(
            'deviceip', 'uid', 'userid', 'name',
            'role', 'password', 'cardno', 'userfingerprints'
        ));
    }


    public function get_User_Attendance()
    {
        $devices = RegisterDevice::where('status', '=', 1)->get();
        $all_attendance_records = [];

        foreach ($devices as $ip) {
            $zk = new ZKTeco($ip->ip_address, $ip->port);
            try {
                $zk->connect();
                $zk->disableDevice();
                $attendaces = $zk->getAttendance();

                // Add attendance records from current device to the array
                foreach ($attendaces as $attendance) {
                    $attendance['port'] = $ip->port;

                    // Check if attendance record already exists in the array
                    $alreadyExists = false;
                    foreach ($all_attendance_records as $record) {
                        if ($record['timestamp'] == $attendance['timestamp']) {
                            $alreadyExists = true;
                            break;
                        }
                    }
                    // Only add attendance records that don't already exist
                    if (!$alreadyExists) {
                        $all_attendance_records[] = $attendance;
                    }
                }
                $zk->clearAttendance();
            } catch (Exception $e) {
                $e->getMessage();
            }
        }

        // Insert all attendance records into the database
        foreach ($all_attendance_records as $attendance) {

            $employee = User::where('user_id', $attendance['id'])->first();
            // DeviceAttendanceRecord::updateOrCreate(
            $attendance_datetime = $attendance['timestamp'];
            // Convert the datetime string to a Carbon instance
            $carbonInstance = Carbon::parse($attendance_datetime);

            // Separate the date
            $dateOnly = $carbonInstance->toDateString();

            $count = MarkTeacherAttendanceModel::whereDate('la_date_time', '=', $dateOnly)->where('la_emp_id', $attendance['id'])->count();
            MarkTeacherAttendanceModel::updateOrCreate(
                ['la_emp_id' => $attendance['id'], 'la_date_time' => $attendance['timestamp']],
                [
                    'la_emp_id' => $attendance['id'],
                    'la_type' => $count == 0 ? 1 : 2,
                    'la_department_id' => $employee->user_department_id,
                    'la_date' => $dateOnly,
                    'la_clg_id' => $employee->user_clg_id,
                    'port' => $attendance['port'],
                    'la_date_time' => $attendance['timestamp'],
                ]
            );
        }
        return redirect()->back();
    }
}
