<!DOCTYPE html>
<html>

<head>
    <title>Artha</title>
    <meta charset="utf-8">
    <meta content="ie=edge" http-equiv="x-ua-compatible">
    <meta content="Artha language" name="keywords">
    <meta content="Artha" name="author">
    <meta content="Artha dashboard" name="description">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <link href="img/favicon.png" rel="shortcut icon">
    <link href="apple-touch-icon.png" rel="apple-touch-icon">

    <link href="css/main.css?version=4.2.0" rel="stylesheet">
    <style>
        .element-header:after {
            background-color: transparent !important;
        }

    </style>
    <style>
        /** 
                Set the margins of the page to 0, so the footer and the header
                can be of the full height and width !
             **/
        @page {
            margin: 0cm 0cm;
        }

        /** Define now the real margins of every page in the PDF **/
        body {
            margin-top: 3cm;
            margin-left: 2cm;
            margin-right: 2cm;
            margin-bottom: 2cm;
        }

        /** Define the header rules **/
        header {
            position: fixed;
            top: 0cm;
            left: 0cm;
            right: 0cm;
            height: 3cm;
        }

        /** Define the footer rules **/
        footer {
            position: fixed;
            bottom: 0cm;
            left: 0cm;
            right: 0cm;
            height: 2cm;
        }

    </style>
</head>

<body class="with-content-panel">

    <header>
        <div class="all-wrapper menu-side with-side-panel">
            <div class="layout-w">
                <div class="content-i">
                    <div class="content-box">
                        <div class="element-wrapper">
                            <div class="user-profile">
                                @php
                                $logo = session('tenant_logo');
                                $t_logo = \App\Helpers\AppGlobal::$App_Domain . '/storage/tenant/logoimage/' . $logo;
                                @endphp
                                <img src="{{$t_logo}}" style="width:100px" alt="Artha Global" />
                                <h5 class="element-header" style="float:right">
                                    {{session('platformname')}}
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </header>

    <footer>

    </footer>

    <main>
        <div class="all-wrapper menu-side with-side-panel">
            <div class="layout-w">
                <div class="content-i">
                    <div class="content-box">
                        <div class="element-wrapper">
                            <div class="user-profile">
                                @php
                                $questions_col = collect(json_decode($Questions, true));
                                $answers_col=collect(json_decode($Answers, true));
                                $a_count=1;
                                $q_count=1;
                                @endphp
                                <div class="up-contents investment-pdtop">
                                    @foreach($UniqueModules as $m)

                                    <h5 class="element-header">
                                        {{$m->modulename}}
                                    </h5>
                                    @php
                                    $m_questions = $questions_col->where('moduleid', $m->moduleid);
                                    $q_count=1;
                                    @endphp
                                    <div class="row invst-pfl">
                                        <div class="col-sm-12">
                                            @if(isset($m_questions))
                                            @foreach($m_questions as $q)

                                            <div class="label">
                                                {!! $q_count.'. Question (Assigned to: '.$q['firstname'].'
                                                '.$q['lastname'].'): '.$q['questiontext'] !!}
                                            </div>
                                            {{-- For Printing Answers.. --}}
                                            @php
                                            $q_answers = $answers_col->where('questionid', $q['questionid']);
                                            $a_count=1;
                                            @endphp
                                            <br />
                                            @foreach($q_answers as $ans)
                                            <div class="label">
                                                {!!'Answer-' .$a_count.' (Answered by: '.$ans['firstname'].'
                                                '.$ans['lastname'].'): '.$ans['answertext']!!}
                                            </div>
                                            @php
                                            $a_count=$a_count+1;
                                            @endphp
                                            @endforeach
                                            @php
                                            $q_count=$q_count+1;
                                            @endphp
                                            @endforeach
                                            @endif

                                        </div>
                                    </div>
                                    @endforeach



                                </div>
                            </div>

                        </div>


                    </div>



                </div>
                <div class="display-type"></div>
            </div>
        </div>
    </main>
    <script src="js/main-custom.js"></script>
</body>

</html>
