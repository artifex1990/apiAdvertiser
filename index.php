<?
    require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
    $APPLICATION->SetTitle("API получения путевок");
?>

<?
    //use Bitrix\Main\UI\Extension;
    use Bitrix\Main\Page\Asset;
    Asset::getInstance()->addJs('https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js');
    //Extension::load('ui.bootstrap4');

    Asset::getInstance()->addCss('https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css');
    Asset::getInstance()->addCss('https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css');
    Asset::getInstance()->addJs('https://code.jquery.com/jquery-3.5.1.slim.min.js');
    Asset::getInstance()->addJs('https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js');
    Asset::getInstance()->addJs('https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js');
    Asset::getInstance()->addJs($templateFolder . 'js/script.js');

?>
    <div class="form-group">
        <label for="country">Страна:</label>
        <select class="selectpicker" id="country" data-live-search="true" title="Страна">
        </select>
    </div>
    <div class="form-group" >
        <label for="city">Город:</label>
        <select class="selectpicker" id="city" data-live-search="true" title="Город">
        </select>
    </div>
    <div class="form-group">
        <label for="search">Поиск:</label>
        <div class="input-group mb-3 col-4">
            <input id="search" type="text" class="form-control" placeholder="Найти" aria-label="Найти" aria-describedby="basic-addon2">
            <div class="input-group-append">
                <button class="btn btn-outline-secondary" id="btn-search" type="button">Искать</button>
            </div>
        </div>
    </div>

</form>

    <h1 id="msg_work"></h1>
    <table id="excursion">

    </table>

<script>


BX.ready(function () {

    var Countries;
    var Citiesdata;
    var citySelect;

    BX.ajax({
        url: '<?=urlencode($templateFolder.'ajax/country.php');?>',
        method: 'POST',
        dataType: 'json',
        timeout: 30,
        async: true,
        processData: true,
        scriptsRunFirst: true,
        emulateOnload: true,
        start: true,
        cache: false,
        onsuccess: function(data){
            Countries = data;
            var option;
            var country;
            for(var key in data) {
                option = document.createElement('option');
                option.text = key;
                option.value = key;

                $('#country').append('<option value="'+key+'">'+key+'</option>');
            }
            $('#country').selectpicker('refresh');
        },
        onfailure: function(){

        }
    });

    $('#country').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
        $('#city').val('');
        $('#city').find('option').remove();
        $('#city').selectpicker('refresh');
        BX.ajax({
            url: '<?=urlencode($templateFolder.'ajax/cities.php');?>',
            data: {'cities' : JSON.stringify(Countries[this.value])},
            method: 'POST',
            dataType: 'json',
            timeout: 30,
            async: true,
            processData: true,
            scriptsRunFirst: true,
            emulateOnload: true,
            start: true,
            cache: false,
            onsuccess: function(data){
                Citiesdata = data;
                var option;
                var city;
                for(var key in data) {
                    option = document.createElement('option');
                    option.text = key;
                    option.value = key;

                    $('#city').append('<option value="'+key+'">'+key+'</option>');
                }
                $('#city').selectpicker('refresh');
            },
            onfailure: function(){

            }
        });
    });

    $('#city').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
        citySelect = Citiesdata[this.value];
    });

    $('#btn-search').click(function () {

        if($('#city').val() && $('#country').val()) {
            $('#msg_work').html('<p style="text-align: center;">Ищу</p>');
            $("#excursion tr").remove();
            BX.ajax({
                url: '<?=urlencode($templateFolder . 'ajax/excursion.php');?>',
                data: {'excursion': JSON.stringify(citySelect), 'search': JSON.stringify($('#search').val())},
                method: 'POST',
                dataType: 'json',
                timeout: 30,
                async: true,
                processData: true,
                scriptsRunFirst: true,
                emulateOnload: true,
                start: true,
                cache: false,
                onsuccess: function (data) {
                    $("#msg_work").html('');
                    var tableExcursion = $('#excursion');
                    var thr = document.createElement('tr');
                    thr.innerHTML += '<th>id</th>';
                    thr.innerHTML += '<th>title</th>';
                    thr.innerHTML += '<th>description</th>';
                    thr.innerHTML += '<th>country</th>';
                    thr.innerHTML += '<th>city</th>';
                    thr.innerHTML += '<th>price</th>';
                    thr.innerHTML += '<th>meeting_point</th>';
                    thr.innerHTML += '<th>duration</th>';
                    thr.innerHTML += '<th>advertiser</th>';
                    tableExcursion.append(thr);

                    var index = 0;
                    for (var advertiser in data) {
                        for (var i = 0; i < data[advertiser].length; i++) {
                            var tr = document.createElement('tr');
                            if (advertiser === 'Tripster') {
                                tr.innerHTML += '<td>' + index++ + '</td>';
                                tr.innerHTML += '<td><a href="' + data[advertiser][i]['url'] + '" target="_blank">' + data[advertiser][i]['title'] + '</a></td>';
                                tr.innerHTML += '<td>' + data[advertiser][i]['tagline'] + '</td>';
                                tr.innerHTML += '<td>' + data[advertiser][i]['city']['country']['name_ru'] + '</td>';
                                tr.innerHTML += '<td>' + data[advertiser][i]['city']['name_ru'] + '</td>';
                                tr.innerHTML += '<td>' + data[advertiser][i]['price']['value_string'] + '</td>';
                                tr.innerHTML += '<td>' + data[advertiser][i]['meeting_point']['text'] + '</td>';
                                tr.innerHTML += '<td>' + data[advertiser][i]['duration'] + '</td>';
                                tr.innerHTML += '<td>' + advertiser + '</td>';
                            }
                            //console.log(tr);
                            if (advertiser === 'Sputnik8') {
                                tr.innerHTML += '<td>' + index++ + '</td>';
                                tr.innerHTML += '<td><a href="' + data[advertiser][i]['url'] + '" target="_blank">' + data[advertiser][i]['title'] + '</a></td>';
                                tr.innerHTML += '<td>' + data[advertiser][i]['description'] + '</td>';
                                tr.innerHTML += '<td>' + data[advertiser][i]['country_slug'] + '</td>';
                                tr.innerHTML += '<td>' + data[advertiser][i]['city_slug'] + '</td>';
                                tr.innerHTML += '<td>' + data[advertiser][i]['price'] + '</td>';
                                tr.innerHTML += '<td>' + data[advertiser][i]['begin_place']['address'] + '</td>';
                                tr.innerHTML += '<td>' + data[advertiser][i]['duration'] + '</td>';
                                tr.innerHTML += '<td>' + advertiser + '</td>';
                            }
                            tableExcursion.append(tr);
                        }
                    }
                },
                onfailure: function () {
                    $("#msg_work").val('');
                }
            });
        } else {
            $('#msg_work').html('<p style="text-align: center;">Страна и город должны быть заполнены!</p>');
        }
    });

});

</script>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>