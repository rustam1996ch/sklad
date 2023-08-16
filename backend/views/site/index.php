<?php

/* @var $this yii\web\View */

$this->title = 'Yii Application';

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'List'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">

    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Complex headers</h4>
            </div>
            <div class="card-content">
                <div class="card-body card-dashboard">
                    <p class="card-text">When using tables to display data, you will often wish to display column
                        information in groups. DataTables fully supports colspan and rowspan in the table's header,
                        assigning the required order listeners to the TH element suitable for that column.</p>
                    <div class="table-responsive">
                        <div id="DataTables_Table_2_wrapper" class="dataTables_wrapper dt-bootstrap4">
                            <div class="row">
                                <div class="col-sm-12">
                                    <table class="table table-striped table-bordered complex-headers dataTable"
                                           id="DataTables_Table_2" role="grid"
                                           aria-describedby="DataTables_Table_2_info"
                                           style="width: 918px;">
                                        <thead>
                                        <tr role="row">
                                            <th rowspan="2" class="align-top sorting_asc" tabindex="0"
                                                aria-controls="DataTables_Table_2" colspan="1" aria-sort="ascending"
                                                aria-label="Name: activate to sort column descending"
                                                style="width: 80px;">
                                                Name
                                            </th>
                                            <th colspan="2" rowspan="1">HR Information</th>
                                            <th colspan="3" rowspan="1">Contact</th>
                                        </tr>
                                        <tr role="row">
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_2"
                                                rowspan="1"
                                                colspan="1" aria-label="Position: activate to sort column ascending"
                                                style="width: 83px;">Position
                                            </th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_2"
                                                rowspan="1"
                                                colspan="1" aria-label="Salary: activate to sort column ascending"
                                                style="width: 81px;">Salary
                                            </th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_2"
                                                rowspan="1"
                                                colspan="1" aria-label="Office: activate to sort column ascending"
                                                style="width: 70px;">Office
                                            </th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_2"
                                                rowspan="1"
                                                colspan="1" aria-label="Extn.: activate to sort column ascending"
                                                style="width: 40px;">Extn.
                                            </th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_2"
                                                rowspan="1"
                                                colspan="1" aria-label="E-mail: activate to sort column ascending"
                                                style="width: 198px;">E-mail
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>


                                        <tr role="row" class="odd">
                                            <td class="sorting_1">Gloria Little</td>
                                            <td>Systems Administrator</td>
                                            <td>$237,500</td>
                                            <td>New York</td>
                                            <td>1721</td>
                                            <td>g.little@datatables.net</td>
                                        </tr>
                                        <tr role="row" class="even">
                                            <td class="sorting_1">Haley Kennedy</td>
                                            <td>Senior Marketing Designer</td>
                                            <td>$313,500</td>
                                            <td>London</td>
                                            <td>3597</td>
                                            <td>h.kennedy@datatables.net</td>
                                        </tr>
                                        <tr role="row" class="odd">
                                            <td class="sorting_1">Hermione Butler</td>
                                            <td>Regional Director</td>
                                            <td>$356,250</td>
                                            <td>London</td>
                                            <td>1016</td>
                                            <td>h.butler@datatables.net</td>
                                        </tr>
                                        <tr role="row" class="even">
                                            <td class="sorting_1">Herrod Chandler</td>
                                            <td>Sales Assistant</td>
                                            <td>$137,500</td>
                                            <td>San Francisco</td>
                                            <td>9608</td>
                                            <td>h.chandler@datatables.net</td>
                                        </tr>
                                        <tr role="row" class="odd">
                                            <td class="sorting_1">Hope Fuentes</td>
                                            <td>Secretary</td>
                                            <td>$109,850</td>
                                            <td>San Francisco</td>
                                            <td>6318</td>
                                            <td>h.fuentes@datatables.net</td>
                                        </tr>
                                        <tr role="row" class="even">
                                            <td class="sorting_1">Howard Hatfield</td>
                                            <td>Office Manager</td>
                                            <td>$164,500</td>
                                            <td>San Francisco</td>
                                            <td>7031</td>
                                            <td>h.hatfield@datatables.net</td>
                                        </tr>
                                        <tr role="row" class="odd">
                                            <td class="sorting_1">Jackson Bradshaw</td>
                                            <td>Director</td>
                                            <td>$645,750</td>
                                            <td>New York</td>
                                            <td>1042</td>
                                            <td>j.bradshaw@datatables.net</td>
                                        </tr>
                                        <tr role="row" class="even">
                                            <td class="sorting_1">Jena Gaines</td>
                                            <td>Office Manager</td>
                                            <td>$90,560</td>
                                            <td>London</td>
                                            <td>3814</td>
                                            <td>j.gaines@datatables.net</td>
                                        </tr>
                                        <tr role="row" class="odd">
                                            <td class="sorting_1">Jenette Caldwell</td>
                                            <td>Development Lead</td>
                                            <td>$345,000</td>
                                            <td>New York</td>
                                            <td>1937</td>
                                            <td>j.caldwell@datatables.net</td>
                                        </tr>
                                        <tr role="row" class="even">
                                            <td class="sorting_1">Jennifer Acosta</td>
                                            <td>Junior Javascript Developer</td>
                                            <td>$75,650</td>
                                            <td>Edinburgh</td>
                                            <td>3431</td>
                                            <td>j.acosta@datatables.net</td>
                                        </tr>
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <th rowspan="1" colspan="1">Name</th>
                                            <th rowspan="1" colspan="1">Position</th>
                                            <th rowspan="1" colspan="1">Salary</th>
                                            <th rowspan="1" colspan="1">Office</th>
                                            <th rowspan="1" colspan="1">Extn.</th>
                                            <th rowspan="1" colspan="1">E-mail</th>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
