<!doctype html>
<html>
<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <title>Beställ faktura</title>
    <link href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css' rel='stylesheet'>
    <link href='' rel='stylesheet'>
    <style>.card {
            margin-bottom: 1.5rem
        }

        .card {
            position: relative;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-direction: column;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-color: #fff;
            background-clip: border-box;
            border: 1px solid #c8ced3;
            border-radius: .25rem
        }

        .card-header:first-child {
            border-radius: calc(0.25rem - 1px) calc(0.25rem - 1px) 0 0
        }

        .card-header {
            padding: .75rem 1.25rem;
            margin-bottom: 0;
            background-color: #f0f3f5;
            border-bottom: 1px solid #c8ced3
        }</style>
    <script type='text/javascript' src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
    <script type='text/javascript' src='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js'></script>
    <script type='text/javascript'></script>
</head>
<body>
<div class="container-fluid">
    <div id="ui-view" data-select2-id="ui-view">
        <div>
            <div class="card">
                <div class="card-header">Faktura
                    <strong>{{ $order->order_number }}</strong>
                    <a class="btn btn-sm btn-secondary float-right mr-1 d-print-none" href="#" onclick="javascript:window.print();" data-abc="true">
                        <i class="fa fa-print"></i> Skriva ut</a>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-sm-4">
                            <h6 class="mb-3">Från:</h6>
                            <div>
                                <strong>{{ $catarine->name }}</strong>
                            </div>
                            <div>{{ $catarine->address }}</div>
                            <div>{{ $catarine->city }}</div>
                            <div>E-post: {{ $catarine->email }}</div>
                            <div>Telefon: {{ $catarine->phone }}</div>
                        </div>
                        <div class="col-sm-4">
                            <h6 class="mb-3">Till:</h6>
                            <div>
                                <strong>{{ $billing->first_name.' '.$billing->last_name }}</strong>
                            </div>
                            <div>{{ $billing->apartment.','.$billing->post_code }}</div>
                            <div>{{ $billing->address.' '.$billing->city }}</div>
                            <div>E-post: {{ $billing->email }}</div>
                            <div>Telefon: {{ $billing->phone }}</div>
                        </div>
                        <div class="col-sm-4">
                            <h6 class="mb-3">Fakturainformation:</h6>
                            <div>Faktura:
                                <strong>{{ $order->order_number }}</strong>
                            </div>
                            <div>{{ date("F j, Y, g:i a",$order->order_date)   }}</div>
                            <div>Orderstatus: {{ $order->order_status }}</div>
                            <div>Betalningsstatus: {{ ($order->order_status=='created')?'Pending':'Completed' }}</div>
                            <div>
                                <strong>Referens: {{ $order->purchaseId }}</strong>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive-sm">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th class="center">#</th>
                                <th>Artikel</th>
                                <th>Bild</th>
                                <th class="center">Kvantitet</th>
                                <th class="center">Frakt</th>
                                <th class="right">Enhetskostnad</th>
                                <th class="right">Total</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $total_price=0; $total_delivery_cost=0; $total_product_cost=0; $i=1; if(!empty($order_products)){ ?>
                            <?php foreach($order_products as $row){ ?>
                            <tr>
                                <td class="center">{{ $i }}</td>
                                <td class="left">{{ $row->product_title }}</td>
                                <td class="left"><img src="{{ URL::to('public/products/main_image/'.$row->product_image) }}" height="70px" width="70px"></td>
                                <td class="center">{{ $row->quantity }}</td>
                                <td class="center">{{ $row->quantity.'x'.$row->per_delivery_cost.' kr' }}</td>
                                <td class="right">{{ $row->price.' kr' }}</td>
                                <td class="right">{{ $row->total_price.' kr' }}</td>
                            </tr>
                            <?php $total_price += $row->total_price; $total_delivery_cost += $row->total_delivery_cost; $total_product_cost += $row->total_product_cost; $i++; } } ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-sm-5"></div>
                        <div class="col-lg-4 col-sm-5 ml-auto">
                            <table class="table table-clear">
                                <tbody>
                                <tr>
                                    <td class="left">
                                        <strong>Delsumma</strong>
                                    </td>
                                    <td class="right">{{ $total_price.' kr' }}</td>
                                </tr>
                                <tr>
                                    <td class="left">
                                        <strong>Fraktkostnad</strong>
                                    </td>
                                    <td class="right">{{ $total_delivery_cost.' kr' }}</td>
                                </tr>
                                <tr>
                                    <td class="left">
                                        <strong>Total</strong>
                                    </td>
                                    <td class="right">
                                        <strong>{{ $total_product_cost.' kr' }}</strong>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>