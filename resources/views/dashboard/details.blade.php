<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">
<head><title>
        Verifica risultati del candidato
    </title><link rel="stylesheet" href="{{ URL::to('public/frontend/Risorse/StyleSheets/StyleApplication.css') }}" media="screen,projection" type="text/css" />

    <style type="text/css">
        /* NAVIGATION */ /* list */
        ul { border: none; list-style: none outside none; margin: 0px; padding: 0px; cursor: pointer; }
        ul li { display: block; }
        ul.menu li, ul.list-float li { float: left; }

    </style>

</head>
<body>
<form method="post" action="./verificarisultaticandidato.aspx?mtr=80011624&amp;fbclid=IwAR3BGcM3EUYaU5G0wmaXP_z1l6Wj7hRufpupV-dKKfq1nTuV5aXKYW1nQHk" id="form1">
    <div class="aspNetHidden">
        <input type="hidden" name="__VIEWSTATE" id="__VIEWSTATE" value="/wEPDwUKLTk5OTAyMzg2MQ9kFgICAw9kFg4CAQ8PFgIeB1Zpc2libGVoZBYEAgEPDxYEHgRUZXh0ZR8AaGRkAgMPDxYEHwFlHwBoZGQCBQ8WAh8BBQg4MDAxMTYyNGQCCQ8WAh8BBQhNQVRVQkJBUmQCDQ8WAh8BBQRLQUxVZAIRDxYCHwEFCjAxLTA2LTE5ODZkAhUPFgIfAQUJQkVOR0FMRVNFZAIXDxYCHgtfIUl0ZW1Db3VudAIBFgJmD2QWDgIBDxYCHwEFKjIwMTggMTkgTk9WRU1CUkUgIENFTEkgU1RBTkRBUkQgKyBDRUxJIDEgaWQCAw8WAh8BBQoxOS0xMS0yMDE4ZAIFDxYCHwEFC0EyIENFTEkgMSBpZAIHDxYCHwEFDVNHRSBGb3JtICBzcmxkAgkPFgIfAQUORXNhbWUgY29tcGxldG9kAgsPFgIfAQUORVNBTUUgU1VQRVJBVE9kAg0PFgIfAQUBIGRkA9HvK2iITuqFGE7LURu3DRvzsEZkTO6OghgkLxV27e0=" />
    </div>

    <div class="aspNetHidden">

        <input type="hidden" name="__VIEWSTATEGENERATOR" id="__VIEWSTATEGENERATOR" value="CCCCEA9C" />
    </div>
    <div class="content-pagina">
        <div id="box-center-center" class="int">

            <div class="box modifica">
                <div class="box adv">


                </div>
            </div>



            <div class="box pratiche">
                <div class="titolo" style="padding: .5% .9%;">
                    Verifica Risultati Candidato
                </div>
                <div class="info-container">
                    <div class="clear" style="float: left; padding: 0 1%; font-weight: bold; color: blue;">
                        <span id="Label2" style="display:inline-block;width:150px;">MATRICOLA:</span>
                    </div>
                    <div style="float: left; margin-left: 1%;">
                            <span>
                                {{ $user->serial_number }}</span>
                    </div>
                    <div class="clear" style="float: left; padding: 0 1%; font-weight: bold; color: blue;">
                        <span id="Label0" style="display:inline-block;width:150px;">COGNOME:</span>
                    </div>
                    <div style="float: left; margin-left: 1%;">
                            <span>
                                {{ $user->last_name }}</span>
                    </div>
                    <div class="clear" style="float: left; padding: 0 1%; font-weight: bold; color: blue;">
                        <span id="Label1" style="display:inline-block;width:150px;">NOME:</span>
                    </div>
                    <div style="float: left; margin-left: 1%;">
                            <span>
                                {{ $user->first_name }}</span>
                    </div>
                    <div class="clear" style="float: left; padding: 0 1%; font-weight: bold; color: blue;">
                        <span id="Label3" style="display:inline-block;width:150px;">DATA DI NASCITA:</span>
                    </div>
                    <div style="float: left; margin-left: 1%;">
                            <span>
                                {{ date('d-m-Y',$user->date_of_birth) }}</span>
                    </div>
                    <div class="clear" style="float: left; padding: 0 1%; font-weight: bold; color: blue;">
                        <span id="Label4" style="display:inline-block;width:150px;">NAZIONALITA&#39;:</span>
                    </div>
                    <div style="float: left; margin-left: 1%;">
                            <span>
                                {{ $user->nationality }}</span>
                    </div>
                </div>
            </div>
            <hr class="big-space" />
            <div class="box pratiche">
                <div class="titolo" style="padding: .5% .9%;">
                    Esami sostenuti e relativi esiti
                </div>
                <div class="info-container">
                    <div class="accordionContent threadslist-header" style="height: 20px; padding: 12px 0; margin-bottom: 0; font-weight: bold;">
                        <div style="float: left; width: 22%; margin-left: 1%;">
                            Sessione
                        </div>
                        <div style="float: left; width: 5%;">
                            Data
                        </div>
                        <div style="float: left; width: 8%; margin-left: 1%;">
                            Esame
                        </div>
                        <div style="float: left; width: 15%; margin-left: 1%;">
                            Centro
                        </div>
                        <div style="float: left; width: 10%; margin-left: 1%;">
                            Parte
                        </div>
                        <div style="float: left; width: 12%; margin-left: 1%;">
                            Esito
                        </div>
                        <div style="float: left; width: 15%; margin-left: 1%;">
                            Note appello
                        </div>
                    </div>
                    <div class="threadslist-content" >
                        <ul class="list">

                            <li class="clear">
                                <div style="float: left; width: 20%; margin: .5% 1%;">
                                    {{ date('Y j F',$user->exam_date) }}  CELI STANDARD + CELI 1 i
                                </div>
                                <div style="float: left; width: 5%;margin-top: .5%">
                                    {{ date('d-m-Y',$user->exam_date) }}
                                </div>
                                <div style="float: left; width: 8%; margin-left: 1%;margin-top: .5%">
                                    {{ $exam->exam_title }}
                                </div>
                                <div style="float: left; width: 15%; margin-left: 1%;margin-top: .5%">
                                    {{ $exam->center }}
                                </div>
                                <div style="float: left; width: 8%; margin-left: 1%;margin-top: .5%">
                                    {{ $exam->exam_status }}
                                </div>
                                <div style="float: left; width: 15%; margin-left: 1%;margin-top: .5%">
                                    {{ $exam->outcome }}
                                </div>
                                <div style="float: left; width: 15%; margin-left: 1%;margin-top: .5%">

                                </div>
                            </li>


                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
</body>
</html>
