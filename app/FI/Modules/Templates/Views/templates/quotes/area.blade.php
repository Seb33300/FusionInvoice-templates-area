<!doctype html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <title>{{ trans('fi.quote') }} {{ $quote->number }}</title>

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
          <p><strong>{{ trans('fi.quote') }} {{ $quote->number }}</strong></p>
          <p>{{ trans('fi.date') }}: {{ $quote->formatted_created_at }}</p>
        </td>
      </tr>
    </table>

    <table id="contacts">
      <tr>
        <td>
          <p>
            <strong>
              @if ($quote->user->company) {{ $quote->user->company }}
              @else {{ $quote->user->name }} @endif
            </strong>
          </p>
          <p>
            {{ $quote->user->formatted_address }}
          </p>
          <p>
            @if ($quote->user->company) {{ $quote->user->name }}<br> @endif
            <a href="mailto:{{ $quote->user->email }}">{{ $quote->user->email }}</a>
          </p>
          <p>
            @if ($quote->user->phone) {{ trans('fi.phone') }}: {{ $quote->user->phone }}<br> @endif
            @if ($quote->user->mobile) {{ trans('fi.mobile') }}: {{ $quote->user->mobile }}<br> @endif
            @if ($quote->user->fax) {{ trans('fi.fax') }}: {{ $quote->user->fax }} @endif
          </p>
          <p>
            <a href="{{ $quote->user->web }}">{{ $quote->user->web }}</a>
          </p>
        </td>
        <td>
          <p>
            <strong>{{ $quote->client->name }}</strong>
          </p>
          <p>
            {{ $quote->client->formatted_address }}
          </p>
          <p>
            <a href="mailto:{{ $quote->client->email }}">{{ $quote->client->email }}</a>
          </p>
          <p>
            @if ($quote->client->phone) {{ trans('fi.phone') }}: {{ $quote->client->phone }}<br> @endif
            @if ($quote->client->mobile) {{ trans('fi.mobile') }}: {{ $quote->client->mobile }}<br> @endif
            @if ($quote->client->fax) {{ trans('fi.fax') }}: {{ $quote->client->fax }} @endif
          </p>
          <p>
            <a href="{{ $quote->client->web }}">{{ $quote->client->web }}</a>
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
          @if ($quote->amount->total_tax > 0)<th class="text-right" style="width:70px;">{{ trans('fi.tax_rate') }}</th>@endif
          <th class="text-right" style="width:80px;">{{ trans('fi.subtotal') }}</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($quote->items as $item)
        <tr>
          <td>
            {{ $item->name }}
            <div class="description">{{ $item->formatted_description }}</div>
          </td>
          <td class="text-right">{{ $item->formatted_quantity }}</td>
          <td class="text-right">{{ $item->formatted_price }}</td>
          @if ($quote->amount->total_tax > 0)<td class="text-right">@if ($item->taxRate) {{ $item->taxRate->formatted_percent }} @endif</td>@endif
          <td class="text-right">{{ $item->amount->formatted_subtotal }}</td>
        </tr>
        @endforeach
      </tbody>
      <tfoot>
      {{--*/ $colspan = 3 /*--}}
      @if ($quote->amount->total_tax > 0)
        {{--*/ $colspan = 4 /*--}}
        <tr>
          <th colspan="{{ $colspan }}" class="border-top text-right text-normal">{{ trans('fi.subtotal') }}</th>
          <td class="border-top text-right">{{ $quote->amount->formatted_item_subtotal }}</td>
        </tr>
        @foreach ($quote->summarized_taxes as $tax)
        <tr>
          <td colspan="{{ $colspan }}" class="text-right text-normal">{{{ mb_strtoupper($tax->name) }}} {{{ $tax->percent }}}</td>
          <td class="text-right">{{{ $tax->total }}}</td>
        </tr>
        @endforeach
        @if (count($quote->summarized_taxes) > 1)
        <tr>
          <th colspan="{{ $colspan }}" class="text-right text-normal">{{ trans('fi.total') }} {{ trans('fi.tax') }}</th>
          <td class="text-right">{{ $quote->amount->formatted_total_tax }}</td>
        </tr>
        @endif
      @endif
        <tr>
          <th colspan="{{ $colspan }}" class="text-right">{{ trans('fi.total') }}</th>
          <td class="text-right"><strong>{{ $quote->amount->formatted_total }}</strong> @if ($quote->is_foreign_currency) ({{ $quote->amount->formatted_converted_total }}) @endif</td>
        </tr>
      </tfoot>
    </table>

    <table id="terms">
      <tr>
        <td>
          @if ($quote->terms) {{ $quote->formatted_terms }} @endif
        </td>
      </tr>
    </table>

  </div>

  <div id="footer" align="center">
    {{ $quote->formatted_footer }}
  </div>

</body>
</html>