@extends('admin.layouts.master')
@section('title', 'E-Learning | HOME')
@section('content')
        <!-- page content -->
<div class="right_col" role="main">
    @if(isset($errors))
        @if ( count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    @endif
    @if(\Session::has('msg'))

    @endif
    <div class="row top_tiles">

        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="tile-stats">
                <div class="icon"><i class="fa fa-users" aria-hidden="true"></i></div>
                <div class="count">{{ $totalTeachers }}</div>
                <h3>Teachers</h3>
            </div>
        </div>

        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="tile-stats">
                <div class="icon"><i class="fa fa-users" aria-hidden="true"></i></div>
                <div class="count">{{ $totalStudents }}</div>
                <h3>Students</h3>
            </div>
        </div>

        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="tile-stats">
                <div class="icon"><i class="fa fa-book" aria-hidden="true"></i></div>
                <div class="count">{{ $totalCourses }}</div>
                <h3>Courses</h3>
            </div>
        </div>
        </div>

    </div>
        <br />
</div>
<!-- /page content -->

@stop
@section('page_js')
    <script>

        var arr_data1 = [
            {{ $studentGraphData }}
        ];

        var arr_data2 = [
            {{ $teacherGraphData }}
        ];

        var chart_plot_01_settings = {
            series: {
                lines: {
                    show: false,
                    fill: true
                },
                splines: {
                    show: true,
                    tension: 0.4,
                    lineWidth: 1,
                    fill: 0.4
                },
                points: {
                    radius: 0,
                    show: true
                },
                shadowSize: 2
            },
            grid: {
                verticalLines: true,
                hoverable: true,
                clickable: true,
                tickColor: "#d5d5d5",
                borderWidth: 1,
                color: '#fff'
            },
            colors: ["rgba(38, 185, 154, 0.38)", "rgba(3, 88, 106, 0.38)"],
            xaxis: {
                tickColor: "rgba(51, 51, 51, 0.06)",
                mode: "time",
                tickSize: [1, "day"],
                //tickLength: 10,
                axisLabel: "Date",
                axisLabelUseCanvas: true,
                axisLabelFontSizePixels: 12,
                axisLabelFontFamily: 'Verdana, Arial',
                axisLabelPadding: 10
            },
            yaxis: {
                ticks: 8,
                tickColor: "rgba(51, 51, 51, 0.06)",
            },
            tooltip: false
        }
        if ($("#chart_plot_01").length){
            console.log('Plot1');

            $.plot( $("#chart_plot_01"), [ arr_data1, arr_data2 ],  chart_plot_01_settings );
        }
    </script>
@stop