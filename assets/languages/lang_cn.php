<?php
// Sidebar.inc.php
define("SIDEBAR_WELCOME", "欢迎");
define("SIDEBAR_OPENTICKET", "待解决问题");
define("SIDEBAR_MYTICKETS", "我的提问");
define("SIDEBAR_ACCSETTINGS", "账号设置");
define("SIDEBAR_LOGOUT", "登出");
define("SIDEBAR_WELCOME_GUEST", "欢迎游客");
define("SIDEBAR_WELCOME_GUEST_TEXT", "请登录以使用提问系统");
define("LOGIN", "登录");
// Index.php
define("INDEX_HEADING", "主页");
define("INDEX", "这里你可以创建和管理你的问题.
使用提问系统需要账号.
你也可以在服务器里创建一个账号");
define("INDEX_BTN", "创建一个新问题");
// Admin.php
define("CAT_DEL", "这个分类已被删除");
define("FAQ_DEL", "这个FAQ条目已被删除");
define("ERROR", "发生错误");
define("CATEGORYS", "分类");
define("ACTION", "动作");
define("QUESTION", "问题");
define("ANSWER", "回答");
define("NOFAQ", "目前还没有常见FAQ入口.");
define("USERNAME", "用户名");
define("RANK", "级别");
define("MEMBER", "序号");
define("SETTINGS", "设置");
define("DISABLED", "禁用");
define("ENABLED", "启用");
define("CAPTCHA_HINT", '你可以在这里创建密匙 <a href="https://www.google.com/recaptcha/admin">Google ReCaptcha</a> (只需要在该项启用的时候!)');
define("SAVE", "保存");
define("SAVED", "更变已保存");
define("CAPTCHA_PUBLIC_KEY", "website key");
define("CAPTCHA_PRIVATE_KEY", "secret key");
define("LANGUAGE", "语言");
define("MC_REGISTER", "mc服务器内注册账号");
define("MC_REGISTER_DESC", "当你启用这个功能，你需要 minecraft 插件，用户可以创建一个新的帐户");
//Addfaq.php
define("FAQ_CREATE_HEADING", "创建FAQ条目");
define("ADD", "Add");
//Addcategory.php
define("CAT_CREATE_HEADING", "创建新的分类");
define("CATEGORY", "分类");
//Createticket.php
define("TICKET_CREATE_HEADING", "创建问题");
define("SEND", "发送");
define("SUBJECT", "主题");
define("MESSAGE", "说点内容吧...");
define("CAPTCHA_FAIL", "验证失败");
//Mytickets.php
define("TITLE", "标题");
define("CREATED_AT", "创建时间");
define("LAST_ANSWER_AT", "最后回答时间");
define("NONE", "无");
define("OPEN", "待解决");
define("CLOSED", "已解决");
define("NO_TICKET", "你现在还没有创建一个提问");
define("MY_TICKETS", "我的提问");
//team.php
define("OPEN_TICKETS", "待解决问题");
define("ALL_TICKETS", "所有问题");
define("NO_OPEN", "目前没有待解决问题");
//ticket.php
define("CREATED_BY", "创建者");
define("CLOSE_BTN", "问题解决？");
define("TICKET_CLOSED", "这个问题已解决");
define("TICKET_ERROR", "没有问题");
define("TICKET_POSTED", "你的回答已发送");
define("TICKET_POSTED_ERR", "这个问题已经解决，但你可以写下你的回答");
define("TICKET_CLOSED_SUCCESS", "问题已解决");
define("TICKET_ALREADY_CLOSED", "这个问题已经解决");
define("TICKET_ANSWER_HEADING", "回答问题");
define("POST", "发送");
//settings.php
define("PW_ERR", "你两次输入的新密码不同");
define("PW_FORM", "新密码");
define("PW_FORM_2", "请再输一次");
define("LASTLOGIN", "最后登录");
define("FIRSTLOGIN", "首次登陆");
//login.php
define("PASSWORD", "密码");
define("PASSWORD_AGAIN", "请再输一次密码");
define("LOGIN_ERR", "登陆失败，请检查您的用户名密码");
define("LOGIN_BTN", "创建新账号");
define("LOGIN_BTN_DESC", "<h3>我如何创建账号?</h3>
<p>在服务器中使用指令 <strong>/ticket createacc Email Password</strong>创建 </p>");
//register.php
define("REGISTER", "注册");
define("REGISTER_USER_ERR", "用户名冲突");
define("REGISTER_EMAIL_ERR", "邮箱已使用");
define("REGISTER_PW_ERR", "密码不匹配");
define("REGISTER_OK", "账号创建成功");
define("DISABLED_HEADER", "错误");
define("DISABLED_MESSAGE", "网页注册已被管理员关闭,请前往服务器注册");
//editaccount.php
define("SAVED_CHANGE", "更变已保存.");
define("EDIT_NO_PERMS", "你不可以编辑这个用户");
define("EDIT_NOT_YOU", "你不可以编辑自己");
define("NO_REQUEST", "没有用户");
//search.php
define("SEARCH", "搜索");
define("SEARCH_KEY", "关键词");
define("NO_SEARCH_RESULT", "没有结果");
 ?>
