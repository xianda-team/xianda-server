#!/usr/bin/env python
# -*- coding: utf-8 -*-
# 部署： fab deploy
# 回滚:  fab rollback

from datetime import datetime
from fabric.api import *

env.user = 'root'
env.hosts = [
  'pro1'
]

# 生产环境nginx指向目录
remote_dist_link = '/opt/web'
# 生产环境代码存放目录
remote_dist_dir = '/opt/version'
# 保留版本数量
keep_version_number = 3


# 更新代码
def update():
  local('git pull')
  local('composer install -vvv')

# 打包
def pack():
  local('rm -f pack.tar.gz')
  local('tar -czvf pack.tar.gz --exclude=\'*.tar.gz\' --exclude=\'fabfile.py\'  .\/')

# 上传
def upload():
  # 远程服务器的临时文件：
  remote_tmp_tar = '/tmp/pack.tar.gz'
  tag = datetime.now().strftime('%y.%m.%d_%H.%M.%S')
  run('rm -f %s' % remote_tmp_tar)
  # 上传tar文件至远程服务器：
  put('pack.tar.gz', remote_tmp_tar)
  # 解压：
  remote_dist_dir_tag = '%s/www.xianda.com@%s' % (remote_dist_dir,tag)
  run('mkdir -p %s' % remote_dist_dir_tag)
  with cd(remote_dist_dir_tag):
        run('tar -xzvf %s' % remote_tmp_tar)
  # 设定新目录的www-data权限:
  run('chown -R www-data:www-data %s' % remote_dist_dir_tag)
  # 删除旧的软链接：
  run('rm -f %s' % remote_dist_link)
  # 创建新的软链接指向新部署的目录：
  run('ln -s %s %s' % (remote_dist_dir_tag, remote_dist_link))
  run('chown -R www-data:www-data %s' % remote_dist_link)
  print('upload done')

# 清理代码存放目录
def clear():
 version_count = int(run('ls %s | head | wc -l' %  remote_dist_dir))
 if version_count > keep_version_number:
    with(cd(remote_dist_dir)):
       run('ls -tr | head -%s | xargs rm -rf' % (version_count - keep_version_number))

# 重启服务
def reload_server():
   #relink_configs
   run('ln -sfn %s/env_init/nginx.conf /etc/nginx/nginx.conf' % remote_dist_link)
   run('ln -sfn %s/env_init/www.conf /etc/php/7.1/fpm/pool.d/www.conf' % remote_dist_link)
   run('ln -sfn %s/env_init/vhost.conf /etc/nginx/sites-enabled' % remote_dist_link)
   run('ln -sfn %s/env_init/php_env.ini /etc/php/7.1/mods-available/php_env.ini' % remote_dist_link)

   run('service php7.1-fpm restart')
   run('nginx -s reload')
   print('reload done')

# 部署
def deploy():
  print('deploy start')
  update()
  pack()
  upload()
  reload_server()
  clear()

# 回滚代码
def rollback():
 remote_prev = run('ls -t %s/ | head  -2 | tail -n 1' % remote_dist_dir)
  if len(remote_prev) > 0:
    run('rm -f %s' % remote_dist_link)
    run('ln -s %s/%s %s' % (remote_prev, remote_dist_dir, remote_dist_link))
    run('chown -R www-data:www-data %s' % remote_dist_link)
    print('rollback done')
  else:
    print('回滚失败：上个版本不存在！')
