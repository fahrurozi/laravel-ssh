

{{-- @servers(['web' => ['rozi@192.168.56.69' => ['password' => '123']]]) --}}
@servers(['web' => ['rozi@192.168.56.69' ]])

{{-- envoy password --}}



@task('deploy' , ['on' => 'web'])
    less /etc/passwd
@endtask
