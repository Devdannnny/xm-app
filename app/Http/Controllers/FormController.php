<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class FormController extends Controller
{

    public function sendEmail($emailSubject, $emailBody, $emailRecipient)
    {
        require_once base_path("vendor/autoload.php");
        $mail = new PHPMailer(true);     // Passing `true` enables exceptions

        try {

            // Email server settings
            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';             //  smtp host
            $mail->SMTPAuth = true;
            $mail->Username = 'your-email@gmail.com';   //  sender username
            $mail->Password = 'your-email-password';       // sender password
            $mail->SMTPSecure = 'tls';                  // encryption - ssl/tls
            $mail->Port = 465;                          // port - 587/465

            $mail->setFrom('devdannny@gmail.com', 'devdannny@gmail.co');
            $mail->addAddress($emailRecipient);

            $mail->isHTML(true);                // Set email content format to HTML

            $mail->Subject = $emailSubject;
            $mail->Body    = $emailBody;

            // $mail->AltBody = plain text version of email body;

            if (!$mail->send()) {
                //  return back()->with("failed", "Email not sent.")->withErrors($mail->ErrorInfo);
                return response()->json(['message' => 'Email not sent.', "mailerError" => null, 'error' => true, 'data' => []]);
            } else {
                return response()->json(['message' => 'Email has been sent', "mailerError" => null, 'error' => false, 'data' => []]);
                //return back()->with("success", "Email has been sent.");
            }
        } catch (Exception $e) {
            // return back()->with('error', 'Message could not be sent.');
            return response()->json(['message' => 'Message could not be sent ', "mailerError" => $e, 'error' => true, 'data' => []]);
        }
    }


    public function submitFrm(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'symbol'          => 'required',
            'startDate'       => 'required',
            'endDate'       => 'required',
            'email'       => 'required',
        ]);

        if ($validator->fails()) {
            // Return a response
            return response()->json(['message' => 'Some fields are empty', 'error' => true, 'data' => []]);
        } else {
            $apiKey = env('API_KEY');
            // Return a response
            $response = Http::withHeaders([
                "X-RapidAPI-Key" =>  $apiKey,
                "X-RapidAPI-Host" => "yh-finance.p.rapidapi.com"
            ])->withOptions([
                "verify" => false
            ])->get("https://yh-finance.p.rapidapi.com/stock/v3/get-historical-data", [
                "symbol" => $request->symbol,
                // "region" => "US"
            ]);

            $data = $response->json()["prices"];

            $startDate = $request->startDate;
            $endDate = $request->endDate;
            $data = array_reduce($data, function ($carry, $item) use ($startDate, $endDate) {
                $date = $item['date'];
                $start = strtotime($startDate);
                $end = strtotime($endDate);
                if ($date >= $start && $date <= $end) {
                    $carry[] = $item;
                }
                return $carry;
            }, []);

            foreach ($data as &$row) {
                $row["date"] = date("Y-m-d", $row["date"]);
            }

            $frmDescription = "";
            $emailResp = null;

            //send email to user
            if (is_array($data) && sizeof($data) > 0) {
                $frmDescription = "Form processed successfully";
                $emailSubject = "The submitted Company (" . $request->compSelected . ")";
                $emailBody = "From " . $startDate . " to " . $endDate;
                $emailResp = $this->sendEmail($emailSubject, $emailBody, $request->email);
                //  echo $emailResp;
            } else {
                $frmDescription = "No record found for the entered query";
            }

            return response()->json(['message' => $frmDescription, 'error' => false, 'data' => $data, "emailInfo" => $emailResp]);
        }
    }

    public function getStockData(Request $request)
    {
        try {
            $apiKey = env('API_KEY');
            // code to fetch data
            $response = Http::withHeaders([
                "X-RapidAPI-Key" =>  $apiKey,
                "X-RapidAPI-Host" => "yh-finance.p.rapidapi.com"
            ])->withOptions([
                "verify" => false
            ])->get("https://yh-finance.p.rapidapi.com/stock/v3/get-historical-data", [
                "symbol" => $request->symbolSelected,
                // "region" => "US"
            ]);

            $data = $response->json()["prices"];

            if (is_array($data) && sizeof($data) > 0) {
                $startDate = $request->startDate;
                $endDate = $request->endDate;
                $data = array_reduce($data, function ($carry, $item) use ($startDate, $endDate) {
                    $date = $item['date'];
                    $start = strtotime($startDate);
                    $end = strtotime($endDate);
                    if ($date >= $start && $date <= $end) {
                        $carry[] = $item;
                    }
                    return $carry;
                }, []);
                foreach ($data as &$row) {
                    $row["date"] = date("Y-m-d", $row["date"]);
                }
                return response()->json($data);
            } else {
                return response()->json($data);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }
}
