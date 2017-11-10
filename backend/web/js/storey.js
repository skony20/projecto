$(document).ready(
    function()
    {
        
     $(".parter").click(
             
             function() {
                iImgId = $(this).attr('rel');
                $.ajax({
                    url: 'makeimagetype',
                    type: 'get',
                    data: {
                        iImgId:iImgId, 
                        iType:1, 
                    },

                });
         }); 
         $(".pietro").click(
             
             function() {

                iImgId = $(this).attr('rel');
                $.ajax({
                    url: 'makeimagetype',
                    type: 'get',
                    data: {
                        iImgId:iImgId, 
                        iType:2, 
                    },

                });
         }); 
        $(".qab").click(
             
             function() {
                $(this).addClass( "active" );
                iPrdId = $(this).attr('rel');
                iAnswer = $(this).attr('relA');
                $.ajax({
                    url: 'answerbyimage',
                    type: 'get',
                    data: {
                        iPrdId:iPrdId, 
                        iAnswer:iAnswer
                    },

                });
         }); 
         $('.szer').change(function()
            {
                iPrdId = $(this).attr('rel2');
                iValue = $(this).val();
                $.ajax({
                    url: "dimensionfromimage",
                    type: 'get',
                    data: {
                        iPrdId:iPrdId, 
                        iValue:iValue,
                        iAttrId:2
                    },
                }); 

            });
            $('.gl').change(function()
            {
                iPrdId = $(this).attr('rel2');
                iValue = $(this).val();
                $.ajax({
                    url: "dimensionfromimage",
                    type: 'get',
                    data: {
                        iPrdId:iPrdId, 
                        iValue:iValue,
                        iAttrId:3
                    },
                }); 

            });
            $('.is').change(function()
            {
                iPrdId = $(this).attr('rel2');
                iValue = $(this).val();
                $.ajax({
                    url: "dimensionfromimage",
                    type: 'get',
                    data: {
                        iPrdId:iPrdId, 
                        iValue:iValue,
                        iAttrId:17
                    },
                }); 

            });
            $('.il').change(function()
            {
                iPrdId = $(this).attr('rel2');
                iValue = $(this).val();
                $.ajax({
                    url: "dimensionfromimage",
                    type: 'get',
                    data: {
                        iPrdId:iPrdId, 
                        iValue:iValue,
                        iAttrId:18
                    },
                }); 

            });
            $('.iwc').change(function()
            {
                iPrdId = $(this).attr('rel2');
                iValue = $(this).val();
                $.ajax({
                    url: "dimensionfromimage",
                    type: 'get',
                    data: {
                        iPrdId:iPrdId, 
                        iValue:iValue,
                        iAttrId:19
                    },
                }); 

            });
    });



