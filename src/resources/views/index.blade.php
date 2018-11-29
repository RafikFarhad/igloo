<!DOCTYPE html>
<html>

<head>
    <title>Igloo Wizard</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <!-- Optional Bootstrap theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r"
        crossorigin="anonymous">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN"
        crossorigin="anonymous">
    <!-- Include SmartWizard CSS -->
    <link href="{{ asset('vendor/igloo/src/dist/css/smart_wizard.css') }}" rel="stylesheet" type="text/css" />
    <!-- Optional SmartWizard theme -->
    <link href="{{ asset('/vendor/igloo/src/dist/css/smart_wizard_theme_arrows.css') }}" rel="stylesheet" type="text/css" />
</head>

<body>
    <div class="container" style="width: 95%">
        <div class="row">
            <h1 class="text-center">
                Igloo Wizard
            </h1>
        </div>

        <div class="row col-md-10 col-md-offset-1">
            <!-- SmartWizard html -->
            <div id="smartwizard">
                <ul>
                    <li>
                        <a href="#step-0">Installation
                            <br/>
                        </a>
                    </li>
                    <li>
                        <a href="#step-1">Model Name
                            <br/>
                        </a>
                    </li>
                    <li>
                        <a href="#step-2">Model Structure
                            <br/>
                        </a>
                    </li>
                    <li>
                        <a href="#step-3">Generate Structure
                            <br/>
                        </a>
                    </li>
                    <li>
                        <a href="#step-4">Submit
                            <br/>
                        </a>
                    </li>
                </ul>

                <div>
                    <div id="step-0" class="text-center">
                        <h2>Installation</h2>
                        <code>composer require farhad/igloo</code>
                        <h2>Full Documentation</h2>
                        <a href="http://github.com/RafikFarhad/Igloo">
                            Full documentation can be found here.
                        </a>
                    </div>
                    <div id="step-1" class="text-center">
                        <hr>
                        <h2>URL of the project</h2>
                        <div id="form-step-0" role="form" data-toggle="validator">
                            <div class="form-group">
                                <div class="col-md-6 com-sm-12">
                                    <input type="text" id="url" value="{{ url('') }}" class="form-control" required>
                                </div>
                                <div class="col-md-6 com-sm-12">
                                    <button id="testBtn" class="btn btn-warning">
                                        <i class="fa fa-exclamation fa-spin"></i> &nbsp; Test</button>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <br>
                        <h2>Namespace</h2>
                        <div id="form-step-6" role="form" data-toggle="validator">
                            <div class="form-group">
                                <div class="col-md-6 com-sm-12">
                                    <input type="text" id="namespace" value="Api/V1" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <br>
                        <h2>Your Desired Model Name</h2>
                        <div id="form-step-1" role="form" data-toggle="validator">
                            <div class="form-group">
                                <div class="col-md-6 com-sm-12">
                                    <input type="text" id="modelName" value="Customer" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <br>
                        <h2>Table Name</h2>
                        <div id="form-step-5" role="form" data-toggle="validator">
                            <div class="form-group">
                                <div class="col-md-6 com-sm-12">
                                    <input type="text" id="tableName" value="customers" class="form-control" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="step-2" class="">
                        <h2>Model Structure</h2>
                        <div class="row" style="margin: -30px 10px 10px 10px">
                            <button id="add-btn" class="btn btn-info pull-right"> <i class="fa fa-plus"></i> Add Column</button>
                        </div>
                        <div class="element-box">
                            <div class="form-inline" id="form-step-2" role="form" data-toggle="validator">
                                <div style="margin-bottom: 10px;">
                                    <div class="form-group">
                                        <input type="text" name="columnName" value="id" class="form-control" placeholder="Column Name" required>
                                    </div>
                                    <div class="form-group">
                                        <select name="dataType" id="dataType" class="form-control dt" required disabled>
                                            <option value="increment" selected>Increment</option>
                                            <option value="integer">Integer</option>
                                            <option value="double(15,2)">Double</option>
                                            <option value="string">String</option>
                                            <option value="text">Text</option>
                                            <option value="boolean">Boolean</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <select name="uniqueStatus" id="uniqueStatus" class="form-control us" required disabled>
                                            <option value="unique" selected>Unique</option>
                                            <option value="!unique">Not Unique</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <select name="nullStatus" id="nullStatus" class="form-control ns" required disabled>
                                            <option value="nullable">Nullable</option>
                                            <option value="!nullable" selected>Required</option>
                                        </select>
                                    </div>
                                    <div class="form-group unshow">
                                        <input type="text" name="defaultValue" value="none" class="form-control" placeholder="Default Value" style="width: 150px"
                                            required disabled>
                                    </div>
                                    <div class="form-group unshow">
                                        <input type="checkbox" name="foreignTable" class="form-control" style="width: 25px"> Foreign Key
                                    </div>
                                </div>
                                <div style="margin-bottom: 10px;">
                                    <div class="form-group">
                                        <input type="text" name="columnName" value="name" class="form-control" placeholder="Column Name" required>
                                    </div>
                                    <div class="form-group">
                                        <select name="dataType" id="dataType1" class="form-control dt" required>
                                            <option value="increment">Increment</option>
                                            <option value="integer">Integer</option>
                                            <option value="double(15,2)">Double</option>
                                            <option value="string" selected>String</option>
                                            <option value="text">Text</option>
                                            <option value="boolean">Boolean</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <select name="uniqueStatus" id="uniqueStatus1" class="form-control us" required>
                                            <option value="unique">Unique</option>
                                            <option value="!unique" selected>Not Unique</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <select name="nullStatus" id="nullStatus1" class="form-control ns" required>
                                            <option value="nullable" selected>Nullable</option>
                                            <option value="!nullable">Required</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="defaultValue" value="none" class="form-control" placeholder="Default Value" style="width: 150px"
                                            required>
                                    </div>
                                    <div class="form-group" style="margin: 10px">
                                        <input type="checkbox" name="foreignTable" value="on" class="form-control" style="width: 25px"> Foreign Key
                                    </div>
                                </div>
                                <div style="display: none">
                                    <div id="inlineFormDiv" style="margin-bottom: 10px;">
                                        <div class="form-group">
                                            <input type="text" name="columnName" value="ColumnName" class="form-control" placeholder="Column Name" required>
                                        </div>
                                        <div class="form-group">
                                            <select name="dataType" id="dataType1" class="form-control dt" required>
                                                <option value="increment">Increment</option>
                                                <option value="integer">Integer</option>
                                                <option value="double(15,2)">Double</option>
                                                <option value="string" selected>String</option>
                                                <option value="text">Text</option>
                                                <option value="boolean">Boolean</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <select name="uniqueStatus" id="uniqueStatus1" class="form-control us" required>
                                                <option value="unique">Unique</option>
                                                <option value="!unique" selected>Not Unique</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <select name="nullStatus" id="nullStatus1" class="form-control ns" required>
                                                <option value="nullable" selected>Nullable</option>
                                                <option value="!nullable">Required</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" name="defaultValue" value="none" class="form-control" placeholder="Default Value" style="width: 150px"
                                                required>
                                        </div>
                                        <div class="form-group" style="margin: 10px">
                                            <input type="checkbox" name="foreignTable" value="on" class="form-control" style="width: 25px"> Foreign Key
                                        </div>
                                        <div class="pull-right">
                                            <button id="delButton" type="button" class="btn btn-sm btn-danger delBtn">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div id="step-3" class="">
                        <h2 class="text-center">Loading...</h2>
                        <div id="confirm" class="text-center">
                            <img src="{{ asset('/vendor/igloo/src/dist/img/loading.gif') }}" alt="Loading..." height="300">
                        </div>
                    </div>
                    <div id="step-4" class="">
                        <h2>Response</h2>
                        <div class="panel panel-default">
                            <!--<div class="panel-heading"></div>-->
                            <div id="response-box" style="padding: 10px"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .unshow {
            display: none !important;
        }

        .delBtn {
            margin-right: 10px;
            margin-top: 10px;
        }
    </style>

    <!-- Include jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Include SmartWizard JavaScript source -->
    <script type="text/javascript" src="{{ asset('vendor/igloo/src/dist/js/jquery.smartWizard.min.js') }}"></script>
    <!-- Include jQuery Validator plugin -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.5/validator.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {

            // Step show event
            $("#smartwizard").on("showStep", function (e, anchorObject, stepNumber, stepDirection, stepPosition) {
                //alert("You are on step "+stepNumber+" now");
                if (stepPosition === 'first') {
                    $("#prev-btn").addClass('disabled');
                } else if (stepPosition === 'final') {
                    $("#next-btn").addClass('disabled');
                } else {
                    $("#prev-btn").removeClass('disabled');
                    $("#next-btn").removeClass('disabled');
                    $("#next-btn").addClass('btn-success');
                }
            });

            // Smart Wizard
            $('#smartwizard').smartWizard({
                selected: 0,
                theme: 'arrows',
                keyNavigation: false,
                transitionEffect: 'slide',
                showStepURLhash: false,
                labelFinish: 'Submit',
                toolbarSettings: {
                    toolbarPosition: 'bottom',
                    // toolbarExtraButtons: [btnFinish, btnCancel]
                }
            });

            $("#smartwizard").on("showStep", function (e, anchorObject, stepNumber, stepDirection) {
                if (stepNumber == 3 && stepDirection === 'backward') {
                    $('#smartwizard').smartWizard("prev");
                    return true;
                }
            });

            $("#smartwizard").on("leaveStep", function (e, anchorObject, stepNumber, stepDirection) {
                var elmForm = $("#form-step-" + stepNumber);
                // stepDirection === 'forward' :- this condition allows to do the form validation
                // only on forward navigation, that makes easy navigation on backwards still do the validation when going next
                if (stepDirection === 'forward' && elmForm) {
                    elmForm.validator('validate');
                    var elmErr = elmForm.children('.has-error');
                    if (elmErr && elmErr.length > 0) {
                        // Form validation failed
                        $('#smartwizard').smartWizard("prev");
                        return false;
                    }
                }
                if (stepNumber == 2 && stepDirection === 'forward') {
                    var columnName = [];
                    $('input[name^="columnName"]').each(function () {
                        columnName.push(($(this).val()));
                    });
                    var dataType = [];
                    $('select.dt').each(function () {
                        dataType.push($(this).val());
                    });
                    var uniqueStatus = [];
                    $('select.us').each(function () {
                        uniqueStatus.push(($(this).val()));
                    });
                    var nullStatus = [];
                    $('select.ns').each(function () {
                        nullStatus.push(($(this).val()));
                    });
                    var defaultValue = [];
                    $('input[name^="defaultValue"]').each(function () {
                        defaultValue.push(($(this).val()));
                    });
                    var foreignTable = [];
                    $('input[name^="foreignTable"]').each(function () {
                        // foreignTable.push(($(this).val()));
                        foreignTable.push(((this.checked ? $(this).val() : "")));
                    });
                    var rootUrl = addhttp($('#url').val());
                    var namespace = $('#namespace').val();
                    var modelName = $('#modelName').val();
                    var tableName = $('#tableName').val();
                    console.log(rootUrl);
                    // console.log(columnName);
                    // console.log(dataType);
                    // console.log(uniqueStatus);
                    // console.log(nullStatus);
                    // console.log(defaultValue);
                    // console.log(foreignTable);
                    var columns = [];
                    var totalSize = columnName.length;
                    for (var i = 0; i < totalSize; i++) {
                        if (i == 2) continue;
                        columns.push({
                            columnName: columnName[i],
                            dataType: dataType[i],
                            nullStatus: nullStatus[i],
                            uniqueStatus: uniqueStatus[i],
                            defaultValue: defaultValue[i],
                            foreignTable: foreignTable[i]
                        });
                    }
                    $.ajax({
                        url: rootUrl + '/igloo/api/make',
                        crossDomain: true,
                        dataType: 'json',
                        type: 'post',
                        contentType: 'application/x-www-form-urlencoded',
                        data: {
                            modelName: (namespace?namespace + '/':namespace) + modelName,
                            tableName: tableName,
                            columns: columns
                        },
                        success: function (data, textStatus, jQxhr) {
                            // console.log(data);
                            $('#response-box').html(data);
                            $('#smartwizard').smartWizard("next");
                        },
                        error: function (jqXhr, textStatus, errorThrown) {
                            console.log(jqXhr);
                            alert('Something went wrong.')
                            $('#response-box').html("<h2>Error</h2><h3>Please check project URL.</h3>");
                            $('#smartwizard').smartWizard("next");
                            // $('#smartwizard').smartWizard("prev");
                        }
                    });
                }

                return true;
            });

            // Add Button Events
            $("#add-btn").on("click", function () {
                $('#inlineFormDiv').clone().appendTo('#form-step-2');
                return true;
            });

            $("#prev-btn").on("click", function () {
                // Navigate previous
                $('#smartwizard').smartWizard("prev");
                return true;
            });

            $("#next-btn").on("click", function () {
                // Navigate next
                $('#smartwizard').smartWizard("next");
                return true;
            });

            $('#testBtn').on('click', function () {
                var btn = $('#testBtn')
                var url = addhttp($('#url').val())
                btn.removeClass()
                btn.attr('class', 'btn btn-info')
                btn.html('<i class="fa fa-spinner fa-spin"></i> Trying to connect')
                setTimeout(function () {
                    $.ajax({
                        url: url + '/igloo/api/ping',
                        dataType: 'text',
                        type: 'get',
                        async: false,
                        success: function (data, textStatus, jQxhr) {
                            btn.attr('class', 'btn btn-success')
                            btn.html('<i class="fa fa-check"></i> Connection is Okay!')
                        },
                        error: function (jqXhr, textStatus, errorThrown) {
                            btn.attr('class', 'btn btn-danger')
                            btn.html('<i class="fa fa-square"></i> Can not connect to Laravel project. Check URL link again.')
                        }
                    });
                }, 1000)

            })

            $('#form-step-1').bind('input', function () {
                var model = $('#modelName').val()
                $('#tableName').val(toSnakeCase(model) + 's')
            });

            $(document).on("click", '.delBtn', function () {
                $(this).parents("#inlineFormDiv").remove();
            })

            function addhttp(url) {
                if (!/^(f|ht)tps?:\/\//i.test(url)) {
                    url = "http://" + url;
                }
                return url;
            }

            function toSnakeCase(str) {
                var upperChars = str.match(/([A-Z])/g);
                if (!upperChars) {
                    return str;
                }

                // var str = str.toString();
                for (var i = 0, n = upperChars.length; i < n; i++) {
                    str = str.replace(new RegExp(upperChars[i]), '_' + upperChars[i].toLowerCase());
                }

                if (str.slice(0, 1) === '_') {
                    str = str.slice(1);
                }

                return str;
            };
            //
            // $("#theme_selector").on("change", function() {
            //     // Change theme
            //     $('#smartwizard').smartWizard("theme", $(this).val());
            //     return true;
            // });
            //
            // // Set selected theme on page refresh
            // $("#theme_selector").change();
        });

    </script>

</body>

</html>