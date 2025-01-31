

<div class="main w3_main_div">

    <div id="wrapper" class="w3ls_wrapper w3layouts_wrapper">
        <div id="steps" style="margin:0 auto;" class="agileits w3_steps">
            <form action="#"  class="w3_form w3l_form_fancy">
                <fieldset class="step agileinfo w3ls_fancy_step">
                    <legend>About</legend>
                    <div class="abt-agile">
                        <div class="abt-agile-left">
                        </div>
                        <div class="abt-agile-right">
                            <h3>{{ $user_profile->user_name }}</h3>
                            <h5>{{ $user_profile->user_designation }}</h5>
                            <ul class="address">
                                <li>
                                    <ul class="address-text">
                                        <li><b>PHONE </b></li>
                                        <li>: {{ $user_profile->user_mobile }}</li>
                                    </ul>
                                </li>
                                <li>
                                    <ul class="address-text">
                                        <li><b>EMAIL </b></li>
                                        <li>: {{ $user_profile->user_email }}</li>
                                    </ul>
                                </li>
                                <li>
                                    <ul class="address-text">
                                        <li><b>ADDRESS </b></li>
                                        <li>: {{ $user_profile->user_address }}</li>
                                    </ul>
                                </li>
                                <li>

                                    <ul class="address-text">
                                        <li><b>IP ADDRESS </b></li>
                                        <li><a >: {{ $ip }}</a></li>
                                    </ul>
                                </li>
                                <li>
                                    <ul class="address-text">
                                        <li><b>BROWSER INFO </b></li>
                                        <li><a>: {{ $browser }}</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <div class="clear"></div>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>


</div>