<?php
#
# Copyright (c) 2002 Steve Price
# All rights reserved.
#
# Redistribution and use in source and binary forms, with or without
# modification, are permitted provided that the following conditions
# are met:
#
# 1. Redistributions of source code must retain the above copyright
#    notice, this list of conditions and the following disclaimer.
# 2. Redistributions in binary form must reproduce the above copyright
#    notice, this list of conditions and the following disclaimer in the
#    documentation and/or other materials provided with the distribution.
#
# THIS SOFTWARE IS PROVIDED BY THE AUTHOR AND CONTRIBUTORS ``AS IS'' AND
# ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
# IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
# ARE DISCLAIMED.  IN NO EVENT SHALL THE AUTHOR OR CONTRIBUTORS BE LIABLE
# FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL
# DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS
# OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION)
# HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
# LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY
# OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF
# SUCH DAMAGE.
#
# $srp: godealertodealer.com/htdocs/admin/users/become.php,v 1.3 2002/09/03 00:36:10 steve Exp $
#

//JJM Added 11/7/2009
if (!empty($_GET['id']))
	$id = $_GET['id'];

if (empty($id) || $id <= 0) {
	header('Location: index.php');
	exit;
}

$skip_privs = 1;
include('../../../include/session.php');

include('../../../include/db.php');
db_connect();

$result = db_do("SELECT id, privs, dealer_id, username FROM users " .
    "WHERE id='$id'");
list($userid, $privs, $dealer_id, $username) = db_row($result);

db_free($result);
db_disconnect();

$privs = decode_privs($privs);

//JJM changed the following lines on 1/31/10
$_SESSION['dealer_id']		= $dealer_id;
$_SESSION['privs']			= $privs;
$_SESSION['userid']			= $userid;
$_SESSION['username']		= $username;
//session_register('dealer_id');
//session_register('privs');
//session_register('userid');
//session_register('username');

header('Location: ../../auction/index.php');
exit;
?>
