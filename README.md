```markdown
# 可滚动分层大楼（静态模板）——已配置 10 层

说明（中文）：

当前状态
- 本模板已生成 10 层：第一层使用 assets/floors/1.png（即你提供的 1.png），其余 9 层使用 assets/floors/2.png 作为占位。
- 页面使用 IntersectionObserver 做懒加载，进入页面后点击“进入大楼”会滚动到第一层。

如何部署你的图片
1. 在仓库中创建目录：assets/floors/
2. 把你的一楼素材上传为：assets/floors/1.png
3. 把占位图上传为：assets/floors/2.png
   - 如果你希望每一层有不同素材，替换 script.js 中相应层的 bgImage 字段为实际文件名或外链 URL。

快速测试（本地）
- 在项目根目录打开一个静态服务器（例如 Python）：
  - python3 -m http.server 8080
- 在浏览器打开 http://localhost:8080/ 查看效果。

自定义层高与素材
- 编辑 script.js 顶部的 floors 数组：
  - height 支持像素（"480px"）、视窗单位（"60vh"）或 "auto"（使用图片自然高度）。
  - bgImage 指向每层的图片 URL（相对或绝对）。
- 运行时你也可以调用：
  - window.setFloors(newArray)
  - window.initBuilding()

注意
- IntersectionObserver 在旧浏览器需 polyfill。
- 如果图片未显示，请检查浏览器控制台的 404 或路径错误信息。

如果你希望我继续做：
- 我可以把你的 1.png、2.png 直接嵌入仓库并打包为 ZIP（请授权/允许上传），
- 或者我可以为每层添加点击热点、楼层侧边导航或视差滚动效果。告诉我你想要哪个功能，我来继续实现。
```