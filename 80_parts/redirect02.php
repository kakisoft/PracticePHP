<?php
echo "redirect";


$statusCode = 302;
$targetUrl  = "http://www.example.com/";
//�u���E�U�����_�C���N�g���܂�
header("HTTP", true,  $statusCode);
header("Location: " . $targetUrl );
//header("Location: http://www.example.com/");

//���_�C���N�g����ۂɁA����ȍ~�̃R�[�h�����s����Ȃ����Ƃ��m�F���Ă�������
//exit;

echo "aa";

