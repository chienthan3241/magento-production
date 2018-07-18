require(['jquery'],function($){

      /*
      // Weiterleitung
      if(document.location.pathname+document.location.search == '/uhren.html'){
        window.location.href = "/uhren-germantom";
      }
      if(document.location.pathname+document.location.search == '/kosmetik.html'){
        window.location.href = "/kosmetik-germantom";
      }
      if(document.location.pathname+document.location.search == '/taschen.html'){
        window.location.href = "/taschen-germantom";
      }
      */
    $(document).ready(function(){

      // Überschift verstecken auf Categorieseite mit brand-filter
      if($('body').hasClass('brand-brand-view')){
        $('.page-title-wrapper').hide();
      }

      // Sprachversionen prüfen
      switch ($('html').attr('lang')) {
        case 'de-DE':
        var gmt_mwst = $('.tax-details');
        //gmt_mwst.html(gmt_mwst.html().replace(/Inkl. 19% Steuern/ig, "Inkl. 19% MwSt")); // Zeile auf Produktseite übersetzen
        var gmt_mwst = 'inkl. MwSt.';break;
        var gmt_viewcart = 'Zum Warenkorb';break;
        case 'en-EN':
        var gmt_mwst = 'VAT included';break;
        var gmt_viewcart = 'View shopping cart';break;
        default:
        var gmt_mwst = 'VAT included';
        var gmt_viewcart = 'View shopping cart';
      }
      //END:Sprachversionen prüfen
      // Übersetzungen:
      $('.gmt-mwst').html(gmt_mwst);
      //from MC: we use translation here
      //$('#minicart-content-wrapper .action.viewcart.primary span').html(gmt_viewcart);

       // Für Produkten auf der Startseite Bestellmöglichkeit und andere Informationen verbergen
       $('.gmt-homepage-produkte .product-item-actions').hide();
       // Logo verbergen:
       var gmt_logo;
       gmt_logo = $('.logo-wrapper').clone();
       //$('.logo-wrapper').remove();
       //$('.rd-navbar-collapse-container').append(gmt_logo);

       var gmt_sorter;
       gmt_sorter = $('.toolbar-sorter .control').html();
       if(gmt_sorter != undefined){
       gmt_sorter = '<div id="gmt-sort">'+gmt_sorter+'</div>';
       $('.breadcrumbs .container').append(gmt_sorter);
       }

       // Produkte auf der Startseite - Preis mit Name - Positionen tauschen
       $( ".gmt-homepage-produkte .product-item-details" ).each(function() {
         var gmt_temp = $( this ).find( ".product-item-name" );
         $( this ).prepend(gmt_temp);
        });


        //Top-Nav-Menu einzelne Punkte aktivieren
        $('.level0 a span').each(function() {
          if(document.location.pathname == '/brands/' && $( this ).html() == 'Brands')
          $( this ).closest('.level0').addClass('active');
        })

       // Product-Detail-Seite
       // END:Product-Detail-Site

       // Startseite
       $('.gmt-start-2block').parent().css({'border':'none','margin-bottom':'3vw','padding-bottom':'0'});
       // END: Startseite

    }); // Document ready

}); // Jquery Container
