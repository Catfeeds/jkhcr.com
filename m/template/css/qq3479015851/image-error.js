function brokerError(obj) {
    obj.onerror = "";
    obj.src = "/default/common/images/error/default_broker.png";
    obj.onerror=null;
    //�޸�΢�ŷ���ͼƬ����ΪĬ��ͼƬ����
    shareImageUrl =  "http://" + window.location.host + "/default/common/images/error/default_broker.png";
}

function defaultListError(obj) {
	obj.onerror = "";
	obj.src = "/default/common/images/error/default_list.jpg";
	obj.onerror=null;
}

function defaultDetailError(obj) {
	obj.onerror = "";
	obj.src = "/default/common/images/error/default_detail.jpg";
	obj.onerror=null;
}
function weixinImageError(obj) {
    obj.onerror = "";
    obj.src = "/default/common/images/error/default_detail.jpg";
    $(".ewm").css("display","none");
    obj.onerror=null;
}
function zhounianError(obj) {
    obj.onerror = "";
    obj.src = "/default/common/images/error/16zhounian.jpg";
    obj.onerror=null;
}
