<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <!-- import CSS -->
    <link rel="stylesheet" href="https://unpkg.com/element-ui/lib/theme-chalk/index.css">
</head>

<body>
<div id="app">
    <template>
        <div class="block">
            <span class="demonstration">开始日期</span>
            <el-date-picker
                    v-model="value1"
                    type="date"
                    placeholder="选择日期">
            </el-date-picker>

            <span class="demonstration">结束日期</span>
            <el-date-picker
                    v-model="value2"
                    type="date"
                    placeholder="选择日期"
                    :picker-options="pickerOptions">
            </el-date-picker>
            <el-button type="primary" @click="getComment">搜索</el-button>
        </div>

    </template>
    <div style="height: 20px"></div>

    <el-table
            :data="tableData"
            border
            style="width: 100%">
        <el-table-column
                prop="id"
                label="记录ID"
                width="180">
        </el-table-column>
        <el-table-column
                prop="lessonId"
                label="课次ID"
                width="180">
        </el-table-column>
        <el-table-column
                prop="userId"
                label="学生ID"
                width="180">
        </el-table-column>
        <el-table-column
                prop="satisfaction"
                label="满意度"
                width="180">
        </el-table-column>
        <el-table-column
                prop="word"
                label="评价内容">
        </el-table-column>
    </el-table>

</div>
</body>
<!-- import Vue before Element -->
<script src="https://unpkg.com/vue/dist/vue.js"></script>
<!-- import JavaScript -->
<script src="https://unpkg.com/element-ui/lib/index.js"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script>
    new Vue({
        el: '#app',
        data() {
            return {
                pickerOptions: {
                    disabledDate(time) {
                        return time.getTime() > Date.now();
                    },
                    shortcuts: [{
                        text: '今天',
                        onClick(picker) {
                            picker.$emit('pick', new Date());
                        }
                    }, {
                        text: '昨天',
                        onClick(picker) {
                            const date = new Date();
                            date.setTime(date.getTime() - 3600 * 1000 * 24);
                            picker.$emit('pick', date);
                        }
                    }, {
                        text: '一周前',
                        onClick(picker) {
                            const date = new Date();
                            date.setTime(date.getTime() - 3600 * 1000 * 24 * 7);
                            picker.$emit('pick', date);
                        }
                    }]
                },
                value1: '',
                value2: '',
                tableData: []
            }
        },
        methods: {
            tableRowClassName({row, rowIndex}) {
                if (rowIndex === 1) {
                    return 'warning-row';
                } else if (rowIndex === 3) {
                    return 'success-row';
                }
                return '';
            },
            getComment() {

                axios.get('http://lk.zxxb.haibian.com/student/feedback/list', {
                    params: {
                        startDate: this.value1,
                        endDate: this.value2
                    }
                }).then((reponse) => {
                    this.tableData = reponse.data.data;
                    console.log(this.tableData);
                }).catch((error) => {
                    console.log(error)
                });
            }
        }
    })
</script>

</html>
