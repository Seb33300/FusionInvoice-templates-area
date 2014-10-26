<!doctype html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <title>{{ trans('fi.invoice') }} {{ $invoice->number }}</title>

  <style>
    * {
      margin: 0px;
    }

    body { 
      font-family: sans-serif;
    }
    
    #wrapper {
      padding: 40px 40px 0 40px;
    }

    a {
      color: inherit;
      text-decoration: none;
    }

    p { 
      padding-bottom: 5px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }

    td, th {
      vertical-align: top;
      text-align: left;
    }

    th {
      white-space: nowrap;
    }

    .text-right {
      text-align: right;
    }

    .text-normal {
      font-weight: normal;
    }

    #header {
      font-size: 100%;
    }

    #contacts {
      font-size: 90%;
      margin-top: 30px;
    }

    #header td:first-child,
    #contacts td:first-child {
      width: 55%;
    }

    #details {
      font-size: 85%;
      margin-top: 30px;
    }

    #details th, #details td {
      padding: 10px;
      border: 1px solid #e8e8e8;
      border-top: none;
      border-bottom: none;
    }

    #details tbody th, #details tbody td {
      border-top: 1px dotted #e8e8e8;
    }

    #details tbody tr:first-child th, #details tbody tr:first-child td {
      border-top: 1px solid #e8e8e8;
    }
    
    #details tfoot {
      border: 1px solid #e8e8e8;
    }

    #details tfoot tr + tr th, #details tfoot tr + tr td {
      padding-top: 0;
    }

    #details .description {
      font-size: 70%;
      padding-top: 3px;
      font-style: italic;
    }

    #terms {
      font-size: 85%;
      margin-top: 30px;
    }

    #footer {
      font-size: 70%;
      width: 100%;
      text-align: center;
      position: absolute;
      bottom: 40px;
    }
  </style>
</head>
<body>

  <div id="wrapper">

    <table id="header">
      <tr>
        <td>
          {{ $logo }}
        </td>
        <td class="text-right">
          <p><strong>{{ trans('fi.invoice') }} {{ $invoice->number }}</strong><br></p>
          <p>{{ trans('fi.date') }}: {{ $invoice->formatted_created_at }}</p>
          <p>{{ trans('fi.due_date') }}: {{ $invoice->formatted_due_at }}</p>
        </td>
      </tr>
    </table>

    <table id="contacts">
      <tr>
        <td>
          <p>
            <strong>
              @if ($invoice->user->company) {{ $invoice->user->company }}
              @else {{ $invoice->user->name }} @endif
            </strong>
          </p>
          <p>
            {{ $invoice->user->formatted_address }}
          </p>
          <p>
            @if ($invoice->user->company) {{ $invoice->user->name }}<br> @endif
            <a href="mailto:{{ $invoice->user->email }}">{{ $invoice->user->email }}</a>
          </p>
          <p>
            @if ($invoice->user->phone) {{ trans('fi.phone') }}: {{ $invoice->user->phone }}<br> @endif
            @if ($invoice->user->mobile) {{ trans('fi.mobile') }}: {{ $invoice->user->mobile }}<br> @endif
            @if ($invoice->user->fax) {{ trans('fi.fax') }}: {{ $invoice->user->fax }} @endif
          </p>
          <p>
            <a href="{{ $invoice->user->web }}">{{ $invoice->user->web }}</a>
          </p>
        </td>
        <td>
          <p>
            <strong>{{ $invoice->client->name }}</strong>
          </p>
          <p>
            {{ $invoice->client->formatted_address }}
          </p>
          <p>
            <a href="mailto:{{ $invoice->client->email }}">{{ $invoice->client->email }}</a>
          </p>
          <p>
            @if ($invoice->client->phone) {{ trans('fi.phone') }}: {{ $invoice->client->phone }}<br> @endif
            @if ($invoice->client->mobile) {{ trans('fi.mobile') }}: {{ $invoice->client->mobile }}<br> @endif
            @if ($invoice->client->fax) {{ trans('fi.fax') }}: {{ $invoice->client->fax }} @endif
          </p>
          <p>
            <a href="{{ $invoice->client->web }}">{{ $invoice->client->web }}</a>
          </p>
        </td>
      </tr>
    </table>

    <table id="details">
      <thead>
        <tr style="background-color: #e8e8e8;">
          <th>{{ trans('fi.product') }}</th>
          <th class="text-right" style="width:70px;">{{ trans('fi.quantity') }}</th>
          <th class="text-right" style="width:70px;">{{ trans('fi.price') }}</th>
          @if ($invoice->amount->total_tax > 0)<th class="text-right" style="width:70px;">{{ trans('fi.tax_rate') }}</th>@endif
          <th class="text-right" style="width:80px;">{{ trans('fi.subtotal') }}</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($invoice->items as $item)
        <tr>
          <td>
            {{ $item->name }}
            <div class="description">{{ $item->formatted_description }}</div>
          </td>
          <td class="text-right">{{ $item->formatted_quantity }}</td>
          <td class="text-right">{{ $item->formatted_price }}</td>
          @if ($invoice->amount->total_tax > 0)<td class="text-right">@if ($item->taxRate) {{ $item->taxRate->formatted_percent }} @endif</td>@endif
          <td class="text-right">{{ $item->amount->formatted_subtotal }}</td>
        </tr>
        @endforeach
      </tbody>
      <tfoot>
      {{--*/ $colspan = 3 /*--}}
      @if ($invoice->amount->total_tax > 0)
        {{--*/ $colspan = 4 /*--}}
        <tr>
          <th colspan="{{ $colspan }}" class="border-top text-right text-normal">{{ trans('fi.subtotal') }}</th>
          <td class="border-top text-right">{{ $invoice->amount->formatted_item_subtotal }}</td>
        </tr>
        @foreach ($invoice->taxRates as $invoiceTaxRate)
        <tr>
          <td colspan="{{ $colspan }}" class="text-right">{{ $invoiceTaxRate->taxRate->name }} {{ $invoiceTaxRate->taxRate->formatted_percent }}</td>
          <td class="text-right">{{ $invoiceTaxRate->formatted_tax_total }}</td>
        </tr>
        @endforeach
        <tr>
          <th colspan="{{ $colspan }}" class="text-right text-normal">{{ trans('fi.total') }} {{ trans('fi.tax') }}</th>
          <td class="text-right">{{ $invoice->amount->formatted_total_tax }}</td>
        </tr>
      @endif
        <tr>
          <th colspan="{{ $colspan }}" class="text-right">{{ trans('fi.total') }}</th>
          <td class="text-right"><strong>{{ $invoice->amount->formatted_total }}</strong> @if ($invoice->is_foreign_currency) ({{ $invoice->amount->formatted_converted_total }}) @endif</td>
        </tr>
      @if ($invoice->amount->paid > 0)
        <tr>
          <td colspan="{{ $colspan }}" class="text-right">{{ trans('fi.paid') }}</td>
          <td class="text-right">{{ $invoice->amount->formatted_paid }} @if ($invoice->is_foreign_currency) ({{ $invoice->amount->formatted_converted_paid }}) @endif</td>
        </tr>
        <tr>
          <td colspan="{{ $colspan }}" class="text-right">{{ trans('fi.balance') }}</td>
          <td class="text-right">{{ $invoice->amount->formatted_balance }} @if ($invoice->is_foreign_currency) ({{ $invoice->amount->formatted_converted_balance }}) @endif</td>
        </tr>
      @endif
      </tfoot>
    </table>

    <table id="terms">
      <tr>
        <td>
          @if ($invoice->terms) {{ $invoice->formatted_terms }} @endif
        </td>
      </tr>
    </table>

  </div>

  <div id="footer" align="center">
    {{ $invoice->formatted_footer }}
  </div>

</body>
</html>