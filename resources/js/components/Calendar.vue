<template>
    <div>
        <v-calendar
        :columns="2"
        title-position="center"
        >
        <template slot='header-title' slot-scope='props'>
            {{props.yearLabel}}年{{props.monthLabel}}
        </template>

        <template slot='day-content' slot-scope='props'>
            <div class="cell-header">
                {{props.day.day}}
            </div>
            <div class="cell-contemt">
            <template
              v-if="dataList.some(date => data.ymd === dateToYYYYMMDD(props.day.date))">
                <div
                class="cell-content-line"
                v-for="content in getContentFromKey(dateToYYYYMMDD(props.day.date))"
                v-bind:key="content">
                  ・{{content}}
                </div>
            </template>
            </div>
        </template>

        </v-calendar>
    </div>

</template>

<script>
export default {
    name: 'calendar',
    data() {
        return {
            dateList: [
                {ymd: '20201223', contents: ['髪を切る','面談','靴を買う']},
                {ymd: '20201214', contents: ['結婚式']},
                {ymd: '20201201', contents: ['妹の誕生日']},
                {ymd: '20201217', contents: ['海に行く！', '野球の練習']}
            ]
        }
    },
    computed: {
    },
    methods: {
        dateToYYYYMDD: function(date) {
            let y = date.getFullYear()
            let m = ('00' + (date.getMonth()+1)).slice(-2)
            let d = ('00' + date.getDate()).slice(-2)
            let result = y + '' + m + '' + d
            return result
        },
        getContentFromKey: function(key) {
            const target = this.dateList.fond((date) =>{
                return (date.ymd === key)
            })
            return target.contents
        }
    }
}
</script>

<style scoped>
.cell-content {
  text-align:left;
  width: 70px;
  height: 50px;
  font-size: 50%;
  /* border: 1px solid #efefef; */
}
.cell-content-line {
  border-bottom: 1px solid #efefef;
}
</style>