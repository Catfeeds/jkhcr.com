var XMLHttpReq;  
function createXMLHttpRequest() {  
    try {  
        XMLHttpReq = new ActiveXObject("Msxml2.XMLHTTP");//IE�߰汾����XMLHTTP  
    }  
    catch(E) {  
        try {  
            XMLHttpReq = new ActiveXObject("Microsoft.XMLHTTP");//IE�Ͱ汾����XMLHTTP  
        }  
        catch(E) {  
            XMLHttpReq = new XMLHttpRequest();//���ݷ�IE�������ֱ�Ӵ���XMLHTTP����  
        }  
    }  
  
}  
function sendAjaxRequest(url) {  
    createXMLHttpRequest();                                //����XMLHttpRequest����  
    XMLHttpReq.open("post", url, true);  
    XMLHttpReq.onreadystatechange = processResponse; //ָ����Ӧ����  
    XMLHttpReq.send(null);  
}  
//�ص�����  
function processResponse() {  
    if (XMLHttpReq.readyState == 4) {  
        if (XMLHttpReq.status == 200) {  
            var text = XMLHttpReq.responseText; 
            if(text == 'true' )
            {
            	tempint=window.clearInterval(tempint);
            	alert("���ѳɹ���ֵ��ҡ�");
				window.location.href = "../../../member/index.php?m=pay&ac=record";
            }
        }  
    }  
} 

function check(out_trade_no)
{
	//console.log("../../../include/payment/wxpay/native_checkresult.php?out_trade_no="+out_trade_no);
	sendAjaxRequest("../../../include/payment/wxpay/native_checkresult.php?out_trade_no="+out_trade_no);		
}

