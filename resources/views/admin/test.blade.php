@extends('layouts.default')

@section('title', trans('adminlte_lang::message.search'))



@section('content')
    <div class="row">
        <div class="box">

            <div class="box-header">
                <h3 class="box-title">Услуги</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                    <div class="row">
                        <div class="col-sm-12">
                            <table id="example1" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                                <thead>
                                    <tr role="row">
                                        <th class="sorting_asc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" style="width: 182.667px;" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending">
                                            Rendering engine
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" style="width: 225.267px;" aria-label="Browser: activate to sort column ascending">
                                            Browser
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" style="width: 198.95px;" aria-label="Platform(s): activate to sort column ascending">
                                            Platform(s)
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" style="width: 156.083px;" aria-label="Engine version: activate to sort column ascending">
                                            Engine version
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" style="width: 111.033px;" aria-label="CSS grade: activate to sort column ascending">
                                            CSS grade
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr role="row" class="odd">
                                        <td class="sorting_1">fdsfsd</td>
                                        <td>Firefox 1.0</td>
                                        <td>Kali Linux 14</td>
                                        <td>1.7</td>
                                        <td>D</td>
                                    </tr>
                                    <tr role="row" class="odd">
                                        <td class="sorting_1">sdfs</td>
                                        <td>Firefox 1.0</td>
                                        <td>Ubuntu 18.08</td>
                                        <td>1.7</td>
                                        <td>C</td>
                                    </tr>
                                    <tr role="row" class="odd">
                                        <td class="sorting_1">vcbcvb</td>
                                        <td>Firefox 1.0</td>
                                        <td>Ubuntu 18.08</td>
                                        <td>1.7</td>
                                        <td>A</td>
                                    </tr>
                                    <tr role="row" class="odd">
                                        <td class="sorting_1">Gecko</td>
                                        <td>Firefox 1.0</td>
                                        <td>Win 98+ / OSX.2+</td>
                                        <td>1.7</td>
                                        <td>A</td>
                                    </tr>
                                    <tr role="row" class="even">
                                        <td class="sorting_1">Gecko</td>
                                        <td>Firefox 1.5</td>
                                        <td>Win 98+ / OSX.2+</td>
                                        <td>1.8</td>
                                        <td>A</td>
                                    </tr>
                                    <tr role="row" class="odd">
                                        <td class="sorting_1">Gecko</td>
                                        <td>Firefox 2.0</td>
                                        <td>Win 98+ / OSX.2+</td>
                                        <td>1.8</td>
                                        <td>A</td>
                                    </tr>
                                    <tr role="row" class="even">
                                        <td class="sorting_1">Gecko</td>
                                        <td>Firefox 3.0</td>
                                        <td>Win 2k+ / OSX.3+</td>
                                        <td>1.9</td>
                                        <td>A</td>
                                    </tr>
                                    <tr role="row" class="odd">
                                        <td class="sorting_1">Gecko</td>
                                        <td>Camino 1.0</td>
                                        <td>OSX.2+</td>
                                        <td>1.8</td>
                                        <td>A</td>
                                    </tr>
                                    <tr role="row" class="even">
                                        <td class="sorting_1">Gecko</td>
                                        <td>Camino 1.5</td>
                                        <td>OSX.3+</td>
                                        <td>1.8</td>
                                        <td>A</td>
                                    </tr>
                                    <tr role="row" class="odd">
                                        <td class="sorting_1">Gecko</td>
                                        <td>Netscape 7.2</td>
                                        <td>Win 95+ / Mac OS 8.6-9.2</td>
                                        <td>1.7</td>
                                        <td>A</td>
                                    </tr>
                                    <tr role="row" class="even">
                                        <td class="sorting_1">Gecko</td>
                                        <td>Netscape Browser 8</td>
                                        <td>Win 98SE+</td>
                                        <td>1.7</td>
                                        <td>A</td>
                                    </tr>
                                    <tr role="row" class="odd">
                                        <td class="sorting_1">Gecko</td>
                                        <td>Netscape Navigator 9</td>
                                        <td>Win 98+ / OSX.2+</td>
                                        <td>1.8</td>
                                        <td>A</td>
                                    </tr>
                                    <tr role="row" class="even">
                                        <td class="sorting_1">Gecko</td>
                                        <td>Mozilla 1.0</td>
                                        <td>Win 95+ / OSX.1+</td>
                                        <td>1</td>
                                        <td>A</td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th rowspan="1" colspan="1">Rendering engine</th>
                                        <th rowspan="1" colspan="1">Browser</th>
                                        <th rowspan="1" colspan="1">Platform(s)</th>
                                        <th rowspan="1" colspan="1">Engine version</th>
                                        <th rowspan="1" colspan="1">CSS grade</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->

        </div>
        <!--<div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Услуги</h3>

                    <div class="box-tools">
                        <div class="input-group input-group-sm" style="width: 150px;">
                            <input type="text" name="table_search" class="form-control pull-right" placeholder="Search">

                            <div class="input-group-btn">
                                <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.box-header --><!--
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                        <tbody><tr>
                            <th>ID</th>
                            <th>User</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Reason</th>
                        </tr>
                        <tr>
                            <td>183</td>
                            <td>John Doe</td>
                            <td>11-7-2014</td>
                            <td><span class="label label-success">Approved</span></td>
                            <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                        </tr>
                        <tr>
                            <td>219</td>
                            <td>Alexander Pierce</td>
                            <td>11-7-2014</td>
                            <td><span class="label label-warning">Pending</span></td>
                            <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                        </tr>
                        <tr>
                            <td>657</td>
                            <td>Bob Doe</td>
                            <td>11-7-2014</td>
                            <td><span class="label label-primary">Approved</span></td>
                            <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                        </tr>
                        <tr>
                            <td>175</td>
                            <td>Mike Doe</td>
                            <td>11-7-2014</td>
                            <td><span class="label label-danger">Denied</span></td>
                            <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                        </tr>
                        </tbody></table>
                </div>
                <!-- /.box-body --><!--
            </div>
            <!-- /.box --><!--
        </div>-->
    </div>
@endsection
