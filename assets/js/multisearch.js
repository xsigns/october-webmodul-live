var objListe = null;
var regionListe = null;
var ortListe = null;
var Search = function() {};
Search.initSearch = function() {
    var inputElem, resultElem;
    inputElem = $('#multisearch');
    resultElem = $('#multiResult');
    inputElem.focus(function() {
        resultElem.show();
        if (objListe === null && regionListe === null && ortListe === null) {
            $.request('onGetResults', {
                method: 'post',
                dataType: "json",
                success: function(resp) {
                    objListe = resp.objekte;
                    regionListe = resp.regionen;
                    ortListe = resp.orte;
                    Search.enterInput();
                    Search.initArrowKeys();
                }
            });
        } else {
            Search.enterInput();
        }
        Search.letzteSucheClick();
    });
    $(document).mouseup(function(e) {
        if (resultElem.is(":visible")) {
            var container = resultElem;
            if (!container.is(e.target) && container.has(e.target).length === 0 && e.target.id !== 'multisearch') {
                container.hide();
                Search.initSearch();
            }
        }
    });
};
Search.enterInput = function() {
    var searchText, objResult, regionResult, ortResult, countResult, objElem, regionElem, ortElem;
    $('#multisearch').keyup(function(e) {
        if (e.which <= 90 && e.which >= 48 || e.which === 8) {
            searchText = $(this).val();
            objResult = filterByValue(objListe, searchText);
            regionResult = filterByValue(regionListe, searchText);
            ortResult = filterByValue(ortListe, searchText);
            countResult = objResult.length + regionResult.length + ortResult.length;
            objElem = $('#multiResult .objList');
            regionElem = $('#multiResult .regionList');
            ortElem = $('#multiResult .ortList');
            if (searchText !== '' && countResult > 0) {
                $('#multiResult .noSearchResults').empty();
                if (objResult.length > 0) {
                    $('#multiResult .objHeadline').show();
                    objElem.empty();
                    for (var i = 0; i < objResult.length; i++) {
                        if (i < maxObjkete) {
                            var objTitle, objUrl;
                            objTitle = objResult[i]['title'];
                            objUrl = objResult[i]['url'];
                            objElem.append('<div class="multisearch-item"><a class="request-item" href="' + objUrl + '">' + objTitle + '</a></div>');
                        }
                    }
                } else {
                    $('#multiResult .objHeadline').hide();
                    objElem.empty();
                }
                if (regionResult.length > 0) {
                    $('#multiResult .regionHeadline').show();
                    regionElem.empty();
                    for (var j = 0; j < regionResult.length; j++) {
                        if (j < maxRegionen) {
                            var regionTitle, regionId;
                            regionTitle = regionResult[j]['title'];
                            regionId = regionResult[j]['id'];
                            regionElem.append('<div class="multisearch-item"><a class="request-item" href="' + listPage + '" data-type="region" data-element="' + regionId +'">' + regionTitle + '</a></div>');
                        }
                    }
                } else {
                    $('#multiResult .regionHeadline').hide();
                    regionElem.empty();
                }
                if (ortResult.length > 0) {
                    $('#multiResult .orteHeadline').show();
                    ortElem.empty();
                    for (var k = 0; k < ortResult.length; k++) {
                        if (k < maxOrte) {
                            var ortTitle, ortPlz, ortId;
                            ortTitle = ortResult[k]['title'];
                            ortPlz = ortResult[k]['plz'];
                            ortId = ortResult[k]['id'];
                            ortElem.append('<div class="multisearch-item"><a class="request-item" href="' + listPage + '" data-type="ort" data-element="' + ortId + '">' + ortTitle + ' ' + ortPlz + '</a></div>');
                        }
                    }
                } else {
                    $('#multiResult .orteHeadline').hide();
                    ortElem.empty();
                }
            } else {
                $('#multiResult .objHeadline').hide();
                $('#multiResult .regionHeadline').hide();
                $('#multiResult .orteHeadline').hide();
                objElem.empty();
                regionElem.empty();
                ortElem.empty();
                if (countResult === 0) {
                    $('#multiResult .noSearchResults').empty().append('<div>' + noResultsText + '</div>');
                } else {
                    $('#multiResult .noSearchResults').empty();
                }
            }
        }
        Search.setSession();
    });
};
Search.initArrowKeys = function() {
    var i = 0;
    $(document).keydown(function (e) {
        if (e.which === 40) {
            var activeCount, activeElement, resultCount;
            activeCount = $('#multiResult').find('.active').length;
            activeElement = $('.multisearch-item.active');
            resultCount = $('.multisearch-item').length;
            if (activeCount === 0) {
                $('.multisearch-item').first().addClass('active');
            }
            if (activeCount > 0) {
                if (i < resultCount - 1) {
                    i++;
                } else {
                    i = 0;
                }
                activeElement.first().removeClass('active');
                $('#multiResult').find('.multisearch-item').eq(i).addClass('active');
            }
        }
        if (e.which === 38) {
            var activeElement2, resultCount2;
            activeElement2 = $('.multisearch-item.active');
            resultCount2 = $('.multisearch-item').length;
            if (i > 0) {
                i--;
            } else {
                i = resultCount2 - 1;
            }
            $('#multiResult').find('.multisearch-item').eq(i).addClass('active');
            activeElement2.last().removeClass('active');
        }
        if (e.which === 13) {
            var clickElement = $('.multisearch-item.active a');
            Search.setSession(true, clickElement);
        }
        if (e.which !== 40 && e.which !== 38 && e.which !== 13) {
            $('.multisearch-item.active').removeClass('active');
            i = 0;
        }
    });
};
Search.setSession = function(click = false, clickedElement = null) {
    if (!click && clickedElement === null) {
        $('#multiResult a.request-item').on('click', function(e) {
            var title, href, dataElement, dataType;
            title = $(this).text();
            href = $(this).attr('href');
            dataElement = $(this).attr('data-element');
            dataType = $(this).attr('data-type');
            e.preventDefault();
            $.request('onResultClick', {
                method: 'post',
                data: {'title' : title, 'url' : href, 'data' : dataElement !== '' ? dataElement : '', 'dataType' : dataType ? dataType : ''},
                success: function() {
                    window.location = href;
                }
            });
        });
    } else {
        var title2, href2, dataElement2, dataType2;
        title2 = $(clickedElement).text();
        href2 = $(clickedElement).attr('href');
        dataElement2 = $(clickedElement).attr('data-element');
        dataType2 = $(clickedElement).attr('data-type');
        $.request('onResultClick', {
            method: 'post',
            data: {'title' : title2, 'url' : href2, 'data' : dataElement2 !== '' ? dataElement2 : '', 'dataType' : dataType2 ? dataType2 : ''},
            success: function() {
                window.location = href2;
            }
        });
    }
};
Search.letzteSucheClick = function() {
    $('#multiResult a.letztesuche-item').on('click', function(e) {
        var dataElement, dataType, href;
        dataElement = $(this).attr('data-element');
        dataType = $(this).attr('data-type');
        href = $(this).attr('href');
        Search.setSession(true, this);
        e.preventDefault();
        if (dataElement) {
            $.request('onSetFilter', {
                method: 'post',
                data: {'dataType' : dataType, 'data' : dataElement},
                success: function() {
                    window.location = href;
                }
            });
        } else {
            window.location = href;
        }
    });
};
function filterByValue(array, string) {
    return array.filter(o =>
        Object.keys(o).some(k => o[k].toLowerCase().includes(string.toLowerCase()))
    );
}