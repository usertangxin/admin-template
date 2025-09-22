<?php

namespace Modules\CrudGenerate\Classes;

class PageViewControlUploadImage extends AbstractPageViewControl
{
    public function getSpecialParams(): array|string
    {
        return <<<'code'
            <a-form-item label="多选">
                <a-radio-group v-model="params.multiple" :options="[{label: '是', value: true}, {label: '否', value: false},]" :default-value="false"></a-radio-group>
            </a-form-item>
            <a-form-item v-if="params.multiple" label="数量限制">
                <a-input-number v-model="params.limit" placeholder="请输入文件数量限制" :min="1" :precision="0" />
            </a-form-item>
            <a-form-item label="备注">
                <a-input v-model="params.remark" placeholder="请输入备注" />
            </a-form-item>
            <a-form-item label="类型限制">
                <a-input v-model="params.accept" placeholder="不填写，使用系统配置默认类型限制" />
            </a-form-item>
            <a-form-item label="单个大小限制">
                <a-input-number v-model="params.file_size" placeholder="不填写，使用系统配置默认大小限制" :min="0" :precision="0" />
            </a-form-item>
            <a-form-item label="存储模式">
                <dict-select v-model="params.storage_mode" code="storage_mode" placeholder="不选，使用系统配置默认存储"></dict-select>
            </a-form-item>
            <a-form-item label="上传模式">
                <dict-select v-model="params.upload_mode" code="upload_mode" placeholder="不选，使用系统配置默认上传模式"></dict-select>
            </a-form-item>
        code;
    }

    public function getFormCodeFragment(): string
    {
        $attrs        = '';
        $multiple     = $this->innerGetSpecialParam('multiple', false);
        $limit        = $this->innerGetSpecialParam('limit', null);
        $remark       = $this->innerGetSpecialParam('remark', '');
        $accept       = $this->innerGetSpecialParam('accept', '');
        $file_size    = $this->innerGetSpecialParam('file_size', null);
        $storage_mode = $this->innerGetSpecialParam('storage_mode', '');
        $upload_mode  = $this->innerGetSpecialParam('upload_mode', '');

        if ($multiple) {
            $attrs .= ' multiple';
            if ($limit !== null) {
                $attrs .= " :limit=\"{$limit}\"";
            }
        }

        if ($remark !== '') {
            $attrs .= " :remark=\"'{$remark}'\"";
        }
        if ($accept !== '') {
            $attrs .= " :accept=\"'{$accept}'\"";
        }
        if ($file_size !== null) {
            $attrs .= " :file-size=\"{$file_size}\"";
        }
        if ($storage_mode !== '') {
            $attrs .= " :storage-mode=\"'{$storage_mode}'\"";
        }
        if ($upload_mode !== '') {
            $attrs .= " :upload-mode=\"'{$upload_mode}'\"";
        }

        return <<<code
            <a-form-item label="{$this->getLabel()}" field="{$this->getFieldName()}">
                <upload-image v-model="formData.{$this->getFieldName()}"$attrs></upload-image>
            </a-form-item>
        code;
    }
}
