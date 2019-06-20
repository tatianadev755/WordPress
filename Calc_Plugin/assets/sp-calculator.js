function spCalculatorPlugin() {

    function formatMoney(n, c, d, t) {
        c = isNaN(c = Math.abs(c)) ? 2 : c,
        d = d == undefined ? "." : d,
        t = t == undefined ? "," : t,
        s = n < 0 ? "-" : "",
        i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
        j = (j = i.length) > 3 ? j % 3 : 0;
        return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
    }

    var allInputs = document.querySelectorAll('.sp-calculator-table input').forEach(function(input) {
        input.addEventListener('keyup',function(){
            this.value = this.value.replace(/[^\d.,]/,'');
            this.value = this.value.toLocaleString();

            //before
            document.querySelector('#before-systems-solid-mo').value = formatMoney(Number(document.querySelector('#before-avg-opportunies-mo').value.replace(/,/g, '').replace(/[^\d.]/,'')) * Number(document.querySelector('#before-closing-ratio').value.replace(/,/g, '').replace(/[^\d.]/,'') * 0.01));
            document.querySelector('#before-monthly-sales').value = '$ '+formatMoney(Number(document.querySelector('#before-systems-solid-mo').value.replace(/,/g, '').replace(/[^\d.]/,'')) * Number(document.querySelector('#before-avg-sys-price').value.replace(/,/g, '').replace(/[^\d.]/,'')));
            document.querySelector('#before-annual-sales').value =  '$ '+formatMoney(Number(document.querySelector('#before-monthly-sales').value.replace(/,/g, '').replace(/[^\d.]/,'')) * 12);
        
            if(Number(document.querySelector('#before-annual-sales').value.replace(/,/g, '').replace(/[^\d.]/,'')) > 0) {
                document.querySelector('#before-annual-sales').style = "border:2px solid rgb(122, 179, 90) !important;padding:3px important;border-radius:10px";
            } else {
                document.querySelector('#before-annual-sales').style = "border:2px solid transparent !important;padding:3px important;border-radius:10px";
            }

            //after
            document.querySelector('#after-avg-opportunies-mo').value = formatMoney(document.querySelector('#before-avg-opportunies-mo').value.replace(/,/g, '').replace(/[^\d.]/,''));
            document.querySelector('#after-systems-solid-mo').value = formatMoney(Number(document.querySelector('#after-closing-ratio').value.replace(/,/g, '').replace(/[^\d.]/,'') * 0.01) * Number(document.querySelector('#after-avg-opportunies-mo').value.replace(/,/g, '').replace(/[^\d.]/,'')));
            document.querySelector('#after-monthly-sales').value = '$ '+formatMoney(Number(document.querySelector('#after-avg-sys-price').value.replace(/,/g, '').replace(/[^\d.]/,'')) * Number(document.querySelector('#after-systems-solid-mo').value.replace(/,/g, '').replace(/[^\d.]/,'')));
            
            document.querySelector('#after-new-annual-sales').value = '$ '+formatMoney(Number(document.querySelector('#after-monthly-sales').value.replace(/,/g, '').replace(/[^\d.]/,'')) * 12);
            if(Number(document.querySelector('#after-new-annual-sales').value.replace(/,/g, '').replace(/[^\d.]/,'')) > 0) {
                document.querySelector('#after-new-annual-sales').style = "border:2px solid rgb(122, 179, 90) !important;padding:3px important;border-radius:10px";
            } else {
                document.querySelector('#after-new-annual-sales').style = "border:2px solid transparent !important;padding:3px important;border-radius:10px";
            }

            document.querySelector('#after-old-annual-sales').value = '$ '+formatMoney(document.querySelector('#before-annual-sales').value.replace(/,/g, '').replace(/[^\d.]/,''));
            
            document.querySelector('#after-additional-sales').value = '$ ' +formatMoney((Number(document.querySelector('#after-new-annual-sales').value.replace(/,/g, '').replace(/[^\d.]/,'')) - Number(document.querySelector('#after-old-annual-sales').value.replace(/,/g, '').replace(/[^\d.]/,''))));
            
            if(Number(document.querySelector('#after-additional-sales').value.replace(/,/g, '').replace(/[^\d.]/,'')) !== 0) {
                document.querySelector('#after-additional-sales').style = "border:2px solid rgb(122, 179, 90) !important;padding:3px important;border-radius:10px";
            } else {
                document.querySelector('#after-additional-sales').style = "border:2px solid transparent !important;padding:3px important;border-radius:10px";
            }
            
            document.querySelector('#after-equipment-sales').value = '$ '+formatMoney(Number(document.querySelector('#after-equipment-percentage-sales').value.replace(/,/g, '').replace(/[^\d.]/,'') * 0.01) * Number(document.querySelector('#after-additional-sales').value.replace(/,/g, '').replace(/[^\d.]/,'')));
        
        });
    });
}

window.addEventListener('load',spCalculatorPlugin)