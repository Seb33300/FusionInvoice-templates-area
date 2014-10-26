#FusionInvoice area templates

Free invoice and quote templates to use with [FusionInvoice](https://www.fusioninvoice.com/)

##How to use
- Download this repository by clicking the "Download Zip" button on the right
- Upload the app/ folder in the root folder of your FusionInvoice installation
- Change the default invoice and quote template in your FusionInvoice system settings
- If you have a logo, recommended height is 150px

##TODO / Known Issues
- $quote->amount->total_tax not working (FusionInvoce core issue)
- Taxes details only work when an invoice tax rate is defined (not with items taxes) (FusionInvoce core issue)
- Mixing invoice tax rate and items taxes make taxes details incorrect (FusionInvoce core issue)
- Translations for "Total taxes", "Total excluding taxes", "Total including taxes" (FusionInvoce core issue)
- Set a fixed height for the details table ([DomPDF issue](https://github.com/dompdf/dompdf/issues/857))