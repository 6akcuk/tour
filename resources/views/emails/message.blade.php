@extends('layouts.email')

@section('content')
    <!-- Start Space -->
    <table width="100%" cellspacing="0" cellpadding="0" border="0" class="full-width">
        <tbody>
        <tr>
            <td height="26">&nbsp;</td>
        </tr>
        </tbody>
    </table>
    <!-- End Space -->


    <table width="550" cellspacing="0" cellpadding="0" border="0" class="full-width" style="border-bottom: 1px solid #ddd">
    <tbody>
    <tr>
        <td height="26">
            <table width="160" align="left" cellspacing="0" cellpadding="0" border="0" class="full-width">
                <tbody>
                <tr>
                    <td>
                        <h2>Message</h2>
                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
    </table>

    <table width="550" cellspacing="0" cellpadding="0" border="0" class="full-width">
    <tbody>
    <tr>
        <td colspan="2" height="20"></td>
    </tr>
    <tr>
        <td height="26">
            <table width="160" align="left" cellspacing="0" cellpadding="0" border="0" class="full-width">
                <tbody>
                <tr>
                    <td>
                        <strong>From:</strong><br>
                        {{ $request->firstname }} {{ $request->lastname }} <br>
                        {{ $request->email }} {{ $request->phone }}
                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="2" height="20"></td>
    </tr>
    <tr>
        <td height="26">
            {!! nl2br($request->message) !!}
        </td>
    </tr>
    <tr>
        <td colspan="2" height="20"></td>
    </tr>
    </tbody>
    </table>

    <!-- Start footer ============ -->
    <table width="600" bgcolor="#464646" align="center" cellspacing="0" cellpadding="0" border="0" class="mobile-width">
        <tbody>
        <tr>
            <td align="center">
                <!-- Start Space -->
                <table width="550" align="center" cellspacing="0" cellpadding="0" border="0" class="content-width">
                    <tbody>
                    <tr>
                        <td  align="center" valign="middle" style="font-family: Arial, Helvetica, sans-serif;font-size:11px; font-weight:normal; color:#cccccc; padding-top:10px; padding-bottom:10px">
                            <strong>Copyright © {{ date('Y') }} BackPackers.com.au</strong>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <!-- End Space -->
            </td>
        </tr>
        </tbody>
    </table><!-- End footer =========== -->
@endsection