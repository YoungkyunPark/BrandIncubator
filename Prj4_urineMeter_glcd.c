/*
 * File:   glcd.c
 * Author: ykpark
 *
 * Created on 2016? 3? 24? (?), ?? 1:51
 */
#include "xc.h"
#include "spi.h"
#include <stddef.h>
#include "../header/defines.h"
#include "../header/frame.h"
#include "glcd.h"
#include <string.h>
#include <stdio.h>

extern void WriteSPI2(unsigned int b);
extern unsigned char gMemCanvas[1920];
extern unsigned char gHour;
extern unsigned char gMin;
extern unsigned char GetHours(void);
extern unsigned char GetMinutes(void);

volatile gLcdResourceState_e gResFlag = UNOCCUPIED;

unsigned char BcdtoDec(unsigned char val){
    return ((val >> 4) * 10) + (val & 0x0F);
}

void initGLCD(){
    GLCD_RESET_ENABLE();
    __delay_ms(2);
    GLCD_RESET_DISABLE();
    __delay_ms(150);
    
    GLCDCommand(0xF1);  /* Last COM electrode */
    GLCDCommand(0x3F);  /* 64-1 */
    GLCDCommand(0xF2);  /* Display start line */
    GLCDCommand(0x00);  /* 0 */
    GLCDCommand(0xF3);  /* Display end line */
    GLCDCommand(0x3F);  /* 0 */
    
    GLCDCommand(0x81);  /* Command for set contrast */
    GLCDCommand(0xB7);  /* contrast */
    
    GLCDCommand(0xC0);  /* Command for Set View */
    GLCDCommand(0x02);  /* Top View */

    GLCDCommand(0xA3);  /* 9.4K per second line rate */
    GLCDCommand(0xE9);  /* Bias ratio to 10 */
    
    GLCDCommand(0xA9);  /* Enable Display */
    GLCDCommand(0xD1);  /* Black and white mode */
    
    GLCDClear();
}

void GLCDCommand(char cmd){
    GLCD_CMD_ENABLE();
    WriteSPI2(cmd);
}

void GLCDData(char data){
    GLCD_DAT_ENABLE();
    WriteSPI2(data);
}

void GLCDPosition(unsigned char col, unsigned char page){
    GLCDCommand(0x10 + (col >> 4));         /* MSB address column */
    GLCDCommand(0x00 + (col & 0x0F));       /* LSB address column */
    GLCDCommand(0x70 + (page >> 4));        /* MSB address Page */
    GLCDCommand(0x60 + (page & 0x0F));      /* LSB address Page */
}

void GLCDClear(void){
    unsigned int size = GLCD_MAXSIZE; /* column * pages */
    unsigned int idx = 0;
    
    GLCDPosition(0,0);
    
    GLCD_DAT_ENABLE();
    for(idx = 0; idx < size ; idx++){
        WriteSPI2(0x00);
    }
}
void GLCDDrawLogo(void){
    unsigned int i = GLCD_MAXSIZE; /* column * pages */
    unsigned int j = 0;
    
    while(gResFlag == OCCUPIED){
        Nop();
    };    
    gResFlag = OCCUPIED;  
    
    GLCDPosition(0,0);
    
    GLCD_DAT_ENABLE();
    for(j = 0; j < i ; j++){
        WriteSPI2(TTM_LOGO[j]);
    }
    
    gResFlag = UNOCCUPIED;
}

void GLCDDrawMainFrame(void){
    unsigned int i = GLCD_MAXSIZE; /* column * pages */
    unsigned int j = 0;
    
    GLCDPosition(0,0);
    
    GLCD_DAT_ENABLE();
    for(j = 0; j < i ; j++){
        WriteSPI2(FRAME_MAIN[j]);
    }
    GLCDDrawBattery(1);     /* Display battery indicator */

    GLCDDrawIconMon(0);
}

void GLCDDrawMonitoringFrame(void){
    unsigned int i = GLCD_MAXSIZE;              /* column * pages */
    unsigned int j = 0;
    
    GLCDPosition(0, 0);
    for(j = 0; j < i ; j++){
        GLCDData(FRAME_MONITORING[j]);
        Nop();
    }
    
    GLCDDrawBattery(1);                         /* Display battery indicator */

    GLCDDrawWatch(GetHours(), GetMinutes());

    GLCDDrawIconMon(1);
}

void GLCDDrawSettingFrame(void){
    unsigned int i = GLCD_MAXSIZE;              /* column * pages */
    unsigned int j = 0;
    
    GLCDPosition(0,0);
    
    GLCD_DAT_ENABLE();
    for(j = 0; j < i ; j++){
        WriteSPI2(FRAME_SETTING[j]);
    }
}

void GLCDClearSettingOption(void){
    unsigned int startIdx = 0;
    unsigned int idx = 0;
    unsigned char startPage = GLCD_SETTING_OPTION_STARTPAGE;
    
    while(gResFlag == OCCUPIED){
        Nop();
    };    
    gResFlag = OCCUPIED;  
    
    GLCDPosition(GLCD_SETTING_OPTION_INDEX, startPage);    
    
    while(idx < GLCD_SETTING_OPTION_SIZE){
        GLCDData(SETTING_CLEAR[startIdx + idx]);
        idx++;
        if((idx % GLCD_SETTING_OPTION_WIDTH) == 0){
            startPage++;
            GLCDPosition(GLCD_SETTING_OPTION_INDEX, startPage);    
        }
    }
    
    gResFlag = UNOCCUPIED;
}

void GLCDDrawSettingMeasPeriod(unsigned char optIdx){
    unsigned int startIdx = (optIdx * GLCD_SETTING_OPTION_SIZE);
    unsigned int idx = 0;
    unsigned char startPage = GLCD_SETTING_OPTION_STARTPAGE;
    
    while(gResFlag == OCCUPIED){
        Nop();
    };    
    gResFlag = OCCUPIED;  
    
    GLCDPosition(GLCD_SETTING_OPTION_INDEX, startPage);    
    
    //GLCDClearSettingOption();
    
    while(idx < GLCD_SETTING_OPTION_SIZE){
        GLCDData(SETTING_MEASURE_TIME[startIdx + idx]);
        idx++;
        if((idx % GLCD_SETTING_OPTION_WIDTH) == 0){
            startPage++;
            GLCDPosition(GLCD_SETTING_OPTION_INDEX, startPage);    
        }
        Nop();
    }
    
    gResFlag = UNOCCUPIED;
}

void GLCDDrawSettingOnOff(unsigned char optIdx){
    unsigned int startIdx = (optIdx * GLCD_SETTING_OPTION_SIZE);
    unsigned int idx = 0;
    unsigned char startPage = GLCD_SETTING_OPTION_STARTPAGE;
    
    while(gResFlag == OCCUPIED){
        Nop();
    };    
    gResFlag = OCCUPIED;  
    
    GLCDPosition(GLCD_SETTING_OPTION_INDEX, startPage);    
    
    while(idx < GLCD_SETTING_OPTION_SIZE){
        GLCDData(SETTING_ONOFF[startIdx + idx]);
        idx++;
        if((idx % GLCD_SETTING_OPTION_WIDTH) == 0){
            startPage++;
            GLCDPosition(GLCD_SETTING_OPTION_INDEX, startPage);    
        }
    }
    
    gResFlag = UNOCCUPIED;
}

void GLCDDrawAlarmFrame(void){
    unsigned int i = GLCD_MAXSIZE; /* column * pages */
    unsigned int j = 0;
    
    while(gResFlag == OCCUPIED){
        Nop();
    };    
    gResFlag = OCCUPIED; 
    
    GLCDPosition(0,0);
    
    for(j = 0; j < i ; j++){
        GLCDData(FRAME_ALARM[j]);
    }
    
    gResFlag = UNOCCUPIED;
}

void GLCDDrawBattery(unsigned char charging){
    unsigned int j = 0;
    
    while(gResFlag == OCCUPIED){
        Nop();
    };    
    gResFlag = OCCUPIED; 
    
    GLCDPosition(GLCD_ICON_BAT_INDEX,0);    
    if(charging == 1){
        while(j < 60){
            GLCDData(BATTERY_NORMAL[j]);
            j++;
            if(j == 30){
                GLCDPosition(206,1);    
            }
        }
    }else{
        while(j< 60){
            GLCDData(BATTERY_CHARGING_V2[j]);
            j++;
            if(j == 30){
                GLCDPosition(206,1);    
            }
        }
    }
    
    gResFlag = UNOCCUPIED; 
}

void GLCDDrawBtnLeft(unsigned char push){
    unsigned int startIdx = (push * GLCD_BUTTON_SIZE);
    unsigned int idx = 0;
    unsigned char startPage = GLCD_BUTTON_STARTPAGE;
    
    while(gResFlag == OCCUPIED){
        Nop();
    };    
    gResFlag = OCCUPIED;   
    
    GLCDPosition(GLCD_BUTTON_LEFT_INDEX, startPage);    
    
    while(idx < GLCD_BUTTON_SIZE){
        GLCDData(BUTTON_LEFT[startIdx + idx]);
        idx++;
        if((idx % GLCD_BUTTON_WIDTH) == 0){
            startPage++;
            GLCDPosition(GLCD_BUTTON_LEFT_INDEX, startPage);    
        }
    }
    
    gResFlag = UNOCCUPIED;
}

void GLCDDrawBtnRight(unsigned char push){
    unsigned int startIdx = (push * GLCD_BUTTON_SIZE);
    unsigned int idx = 0;
    unsigned char startPage = GLCD_BUTTON_STARTPAGE;
    
    while(gResFlag == OCCUPIED){
        Nop();
    };    
    gResFlag = OCCUPIED;   
    
    GLCDPosition(GLCD_BUTTON_RIGHT_INDEX, startPage);    
    
    while(idx < GLCD_BUTTON_SIZE){
        GLCDData(BUTTON_RIGHT[startIdx + idx]);
        idx++;
        if((idx % GLCD_BUTTON_WIDTH) == 0){
            startPage++;
            GLCDPosition(GLCD_BUTTON_RIGHT_INDEX, startPage);    
        }
    }
    
    gResFlag = UNOCCUPIED;
}

void GLCDDrawIconMon(unsigned char mon){
    unsigned int startIdx = (mon * GLCD_ICON_SIZE);
    unsigned int idx = 0;
    unsigned char startPage = GLCD_ICON_STARTPAGE;
    
    while(gResFlag == OCCUPIED){
        Nop();
    };    
    gResFlag = OCCUPIED;   
    
    GLCDPosition(GLCD_ICON_MONITORING_INDEX, startPage);    
    
    while(idx < GLCD_ICON_SIZE){
        GLCDData(ICON_MONITORING[startIdx + idx]);
        idx++;
        if((idx % GLCD_ICON_WIDTH) == 0){
            startPage++;
            GLCDPosition(GLCD_ICON_MONITORING_INDEX, startPage);    
        }
    }
    
    gResFlag = UNOCCUPIED;
}

void GLCDDrawIconAlarm(unsigned char alm){
    unsigned int startIdx = 0;
    unsigned int idx = 0;
    unsigned char startPage = GLCD_ICON_STARTPAGE;
    const unsigned char *arrAddr = NULL;
    
    if(alm == 1){
        arrAddr = ICON_ALARM;
    }else{
        arrAddr = ICON_BLANK;
    }
    
    while(gResFlag == OCCUPIED){
        Nop();
    };    
    gResFlag = OCCUPIED;   
    
    GLCDPosition(GLCD_ICON_ALARM_INDEX, startPage);    
    
    while(idx < GLCD_ICON_SIZE){
        GLCDData(arrAddr[startIdx + idx]);
        idx++;
        
        if((idx % GLCD_ICON_WIDTH) == 0){
            startPage++;
            GLCDPosition(GLCD_ICON_ALARM_INDEX,startPage);    
        }
    }
    
    gResFlag = UNOCCUPIED;
}

void GLCDDrawIconHold(unsigned char hld){
    unsigned int startIdx = 0;
    unsigned int idx = 0;
    unsigned char startPage = GLCD_ICON_STARTPAGE;
    const unsigned char *arrAddr = NULL;
    
    if(hld == 1){
        arrAddr = ICON_HOLD;
    }else{
        arrAddr = ICON_BLANK;
    }
    
    while(gResFlag == OCCUPIED){
        Nop();
    };    
    gResFlag = OCCUPIED;   
    
    GLCDPosition(GLCD_ICON_HOLD_INDEX, startPage);    
    
    while(idx < GLCD_ICON_SIZE){
        GLCDData(arrAddr[startIdx + idx]);
        idx++;
        if(idx == GLCD_ICON_WIDTH){
            startPage++;
            GLCDPosition(GLCD_ICON_HOLD_INDEX, startPage);
        }
    }
    
    gResFlag = UNOCCUPIED;
}

void GLCDDrawIconComm(unsigned char comm){
    unsigned int startIdx = 0;
    unsigned int idx = 0;
    unsigned char startPage = GLCD_ICON_STARTPAGE;
    const unsigned char *arrAddr = NULL;
    
    if(comm == 1){
        arrAddr = ICON_COMM;
    }else{
        arrAddr = ICON_BLANK;
    }
    
    while(gResFlag == OCCUPIED){
        Nop();
    };    
    gResFlag = OCCUPIED;   
    
    GLCDPosition(GLCD_ICON_COMM_INDEX, startPage);    
    
    while(idx < GLCD_ICON_SIZE){
        GLCDData(arrAddr[startIdx + idx]);
        idx++;
        if((idx % GLCD_ICON_WIDTH) == 0){
            startPage++;
            GLCDPosition(GLCD_ICON_COMM_INDEX, startPage);    
        }
    }
    
    gResFlag = UNOCCUPIED;
}

void GLCDDrawSettingOptTitle(unsigned char offset){
    unsigned int startIdx = (offset * GLCD_SETTING_OPTTITLE_SIZE);
    unsigned int idx = 0;
    unsigned char page = GLCD_SETTING_OPTTITLE_STARTPAGE;
    
    while(gResFlag == OCCUPIED){
        Nop();
    };    
    gResFlag = OCCUPIED;   
    
    GLCDPosition(GLCD_SETTING_OPTTITLE_INDEX, page);    
    
    while(idx < GLCD_SETTING_OPTTITLE_SIZE){
        GLCDData(SETTING_OPT_TITLE[startIdx + idx]);
        idx++;
        if((idx % GLCD_SETTING_OPTTITLE_WIDTH) == 0){
            page++;
            GLCDPosition(GLCD_SETTING_OPTTITLE_INDEX, page);    
        }
    }
    gResFlag = UNOCCUPIED;
}

void GLCDDrawVolume(unsigned char num, unsigned char sym, unsigned char unit){
    unsigned int startIdx = (num * GLCD_VOLUME_UNIT_SIZE);
    unsigned char page = GLCD_VOLUME_UNIT_STARTPAGE;
    unsigned int idx = 0;
    unsigned char pxByte = 0;
    unsigned char startCol = GLCD_VOLUME_COL_INDEX + ((4 - unit) * GLCD_VOLUME_UNIT_WIDTH);
    GLCDPosition(startCol, page);    
 
    while(idx < GLCD_VOLUME_UNIT_SIZE){
#if 1
        switch(sym){
            case GLCD_UNIT_DOT:
                if((idx == 28) || (idx == 29)){
                    pxByte = (NUMSET_VOLUME[startIdx + idx] | 0x18);    /* add dot */
                }else{
                    pxByte = NUMSET_VOLUME[startIdx + idx];             /* plane number */
                }
                break;
            case GLCD_UNIT_BLANK:
                pxByte = NUMSET_VOLUME[GLCD_UNIT_BLANK_DEF_IDX + idx];
                break;
            default:
                pxByte = NUMSET_VOLUME[startIdx + idx];                 /* plane number */
                break;
        }
#else
        if((sym == GLCD_UNIT_DOT) && ((idx == 28) || (idx == 29))){
            pxByte = (NUMSET_VOLUME[startIdx + idx] | 0x18);    /* add dot */
        }else{
            pxByte = NUMSET_VOLUME[startIdx + idx];             /* plane number */
        }        
#endif        
        GLCDData(pxByte);                                         /* display number */
        
        idx++;
        
        if((idx % GLCD_VOLUME_UNIT_WIDTH) == 0){                /* change page */
            page++;
            GLCDPosition(startCol, page);
        }
        //Nop();
    }
}

void GLCDDrawTotal(unsigned char num, unsigned char sym, unsigned char unit){
    unsigned int startIdx = (num * GLCD_TOTAL_UNIT_SIZE);
    unsigned char page = GLCD_TOTAL_UNIT_STARTPAGE;
    unsigned int idx = 0;
    unsigned char pxByte = 0;
    unsigned char startCol = GLCD_TOTAL_COL_INDEX + ((4 - unit) * GLCD_TOTAL_UNIT_WIDTH);
    GLCDPosition(startCol, page);   
    
    while(idx < GLCD_TOTAL_UNIT_SIZE){
#if 0
        if((sym == 1) && ((idx == 28) || (idx == 29))){
            pxByte = (NUMSET_TOTAL[startIdx + idx] | 0x03);    /* add dot */
        }else{
            pxByte = NUMSET_TOTAL[startIdx + idx];             /* plane number */
        }        
        
        GLCDData(pxByte);                                         /* display number */
        
        idx++;
        
        if((idx % GLCD_TOTAL_UNIT_WIDTH) == 0){                /* change page */
            page++;
            GLCDPosition(startCol, page);
        }
#else
        switch(sym){
            case GLCD_UNIT_DOT:
                if((idx == 28) || (idx == 29)){
                    pxByte = (NUMSET_TOTAL[startIdx + idx] | 0x18);    /* add dot */
                }else{
                    pxByte = NUMSET_TOTAL[startIdx + idx];             /* plane number */
                }
                break;
            case GLCD_UNIT_BLANK:
                pxByte = NUMSET_TOTAL[GLCD_UNIT_BLANK_DEF_IDX + idx];
                break;
            default:
                pxByte = NUMSET_TOTAL[startIdx + idx];                  /* plane number */
                break;
        }
#endif
        GLCDData(pxByte);                                         /* display number */
        
        idx++;
        
        if((idx % GLCD_TOTAL_UNIT_WIDTH) == 0){                /* change page */
            page++;
            GLCDPosition(startCol, page);
        }
//        Nop();
    }
}

void GLCDDrawRecord(unsigned char record, unsigned char* volume, unsigned char hour, unsigned char min, unsigned char sec, unsigned char yy, unsigned char mm, unsigned char dd){
    volatile unsigned char memCanvas[GLCD_RECORD_BASE_SIZE] = {0};
    unsigned int arrStartIdx = 0;
    unsigned int memCanvasPos = 0;
    unsigned int fetchIterator = 0;
    unsigned char page = 0;
    unsigned char volumeStrIdx = 0;
    unsigned char column = 0;
    volatile unsigned char aTimeStr[6] = {0};
    volatile unsigned char iter = 0;
    
    memcpy((void *)memCanvas, RECORD_BASE, (sizeof(unsigned char) * GLCD_RECORD_BASE_SIZE) );
    
    /*------------------------------------------------------------------------*/
    /* draw record counter number to memory                                   */
    /*------------------------------------------------------------------------*/
    arrStartIdx = (record * GLCD_RECORD_NUM_SIZE);
    fetchIterator = 0;
    page = GLCD_RECORD_NUM_STARTPAGE;
    column = GLCD_RECORD_NUM_COL_INDEX;    
    
    memCanvasPos = ((page * GLCD_RECORD_BASE_WIDTH) + column);       
    
    while(fetchIterator < GLCD_RECORD_NUM_SIZE){
        memCanvas[memCanvasPos] = MON_NUMSET_RECNUM[arrStartIdx + fetchIterator];
        memCanvasPos++;
        fetchIterator++;
        Nop();
    }
    
    memCanvasPos = 0;    
    fetchIterator = 0;
    /*------------------------------------------------------------------------*/
    /* draw volume to memory                                                  */
    /*------------------------------------------------------------------------*/
    /* draw sign -------------------------------------------------------------*/
    if(volume[0] != 1){
        memCanvasPos = (GLCD_RECORD_BASE_WIDTH * 2);    
        arrStartIdx = volume[0] * 5;
        
        while(fetchIterator < 5){
            memCanvas[memCanvasPos] = REC_VOL_SIGN[arrStartIdx + fetchIterator];
            memCanvasPos++;
            fetchIterator++;
        }        
    }
    
    /* draw volume numbers ---------------------------------------------------*/
    for(volumeStrIdx = 1 ; volumeStrIdx < 5 ; volumeStrIdx++){
        if(volume[volumeStrIdx] == 10){
            arrStartIdx = 300;  /* blank */
        }else{
            arrStartIdx = (volume[volumeStrIdx] * GLCD_RECORD_VOLUME_SIZE);
        }
        
        fetchIterator = 0;
        page = GLCD_RECORD_VOLUME_STARTPAGE;
        column = GLCD_RECORD_VOLUME_COL_INDEX + ((volumeStrIdx - 1) * GLCD_RECORD_VOLUME_WIDTH);
        memCanvasPos = ((page * GLCD_RECORD_BASE_WIDTH) + column);       

        while(fetchIterator < GLCD_RECORD_VOLUME_SIZE){
            memCanvas[memCanvasPos] = RECORD_NUMSET_VOLUME[arrStartIdx + fetchIterator];

            memCanvasPos++;
            fetchIterator++;

            if((fetchIterator % GLCD_RECORD_VOLUME_WIDTH) == 0){
                page++;
                memCanvasPos = ((page * GLCD_RECORD_BASE_WIDTH) + column); 
            }
            Nop();
        }
    }
    
    /*------------------------------------------------------------------------*/
    /* draw hours and minutes to memory canvas                                */
    /*------------------------------------------------------------------------*/
    hour = BcdtoDec(hour);
    min = BcdtoDec(min);
    sec = BcdtoDec(sec);
    
    aTimeStr[0] = (unsigned char)(hour/10);
    aTimeStr[1] = (hour%10);
    aTimeStr[2] = (min/10);
    aTimeStr[3] = (min%10);
    aTimeStr[4] = (sec/10);
    aTimeStr[5] = (sec%10);
    
    memCanvasPos = 0;
    fetchIterator = 0;
            
    for(iter = 0 ; iter < 4 ; iter++){        
        page = GLCD_RECORD_TIME_STARTPAGE;
        //column = GLCD_RECORD_TIME_COL_INDEX;
        column = GLCD_RECORD_TIME_COL_INDEX + (iter * GLCD_RECORD_TIME_WIDTH);
        if(iter >= 2){  /* Skip colon(WATCH_BASE include colon) */
            column += 3;                
        }  
        if(iter >= 4){  /* Skip colon(WATCH_BASE include colon) */
            column += 3;                
        }  
        
        memCanvasPos = ((page * GLCD_RECORD_BASE_WIDTH) + column);  
        arrStartIdx = (aTimeStr[iter] * GLCD_RECORD_TIME_SIZE);  
        while(fetchIterator < GLCD_RECORD_TIME_SIZE){
            memCanvas[memCanvasPos] = RECORD_NUMSET_TIME[ (arrStartIdx + fetchIterator) ];
            
            memCanvasPos++;
            fetchIterator++;
            
            if((fetchIterator % GLCD_RECORD_TIME_WIDTH) == 0){
                page++;
                memCanvasPos = ((page * GLCD_WATCH_BASE_WIDTH) + column);
            }
        }          
        
        column += GLCD_RECORD_TIME_WIDTH; 
        page = 0;
        fetchIterator = 0;
    }
    
    /*------------------------------------------------------------------------*/
    /* draw Year to memory                                                    */
    /*------------------------------------------------------------------------*/
    
    /*------------------------------------------------------------------------*/
    /* draw Month to memory                                                   */
    /*------------------------------------------------------------------------*/
    
    /*------------------------------------------------------------------------*/
    /* draw date to memory                                                    */
    /*------------------------------------------------------------------------*/
    
    
    /*------------------------------------------------------------------------*/
    /* dump memory canvas to LCD                                              */
    /*------------------------------------------------------------------------*/
    page = GLCD_RECORD_BASE_STARTPAGE;
    column = GLCD_RECORD_BASE_COL_INDEX;
    
    while(gResFlag == OCCUPIED){
        Nop();
    };    
    gResFlag = OCCUPIED;   
    
    fetchIterator = 0;
    
    GLCDPosition(column, page);    
    
    while(fetchIterator < GLCD_RECORD_BASE_SIZE){
        GLCDData(memCanvas[fetchIterator]);
        fetchIterator++;
        if((fetchIterator % GLCD_RECORD_BASE_WIDTH) == 0){
            page++;
            GLCDPosition(column, page);    
        }
        //Nop();
    }
    
    gResFlag = UNOCCUPIED;
}

void GLCDDrawMeasures(volatile unsigned char* aVolume, volatile unsigned char* aTotal){
    volatile unsigned char memCanvas[GLCD_MEASURES_BASE_SIZE] = {0};
    unsigned int arrStartIdx = 0;
    unsigned int memCanvasPos = 0;
    unsigned int fetchIterator = 0;
    unsigned char page = 0;
    unsigned char volumeStrIdx = 0;
    unsigned char column = 0;
    
    memcpy((void *)memCanvas, MEASURES_BASE, sizeof(unsigned char) * GLCD_MEASURES_BASE_SIZE);    
    
    /*------------------------------------------------------------------------*/
    /* draw volume to memory canvas                                           */
    /*------------------------------------------------------------------------*/
    
    /* Draw sign */
    if(aVolume[0] != 1){
        memCanvasPos = (GLCD_MEASURES_BASE_WIDTH);    
        arrStartIdx = aVolume[0] * 5;
        
        while(fetchIterator < 5){
            memCanvas[memCanvasPos] = REC_VOL_SIGN[arrStartIdx + fetchIterator];
            memCanvasPos++;
            fetchIterator++;
            Nop();
        }        
    }
    
    /* Draw Numbers */
    for(volumeStrIdx = 1 ; volumeStrIdx < 5 ; volumeStrIdx++){
        if(aVolume[volumeStrIdx] == 10){
            arrStartIdx = GLCD_UNIT_BLANK_DEF_IDX;  /* blank */
        }else{
            arrStartIdx = (aVolume[volumeStrIdx] * GLCD_VOLUME_UNIT_SIZE);
        }
        
        fetchIterator = 0;
        page = GLCD_MEASURES_VOLUME_STARTPAGE;
        column = GLCD_MEASURES_VOLUME_COL_INDEX + ((volumeStrIdx - 1) * GLCD_MEASURES_VOLUME_WIDTH);

        memCanvasPos = ((page * GLCD_MEASURES_BASE_WIDTH) + column);       

        while(fetchIterator < GLCD_MEASURES_VOLUME_SIZE){
            memCanvas[memCanvasPos] = NUMSET_VOLUME[arrStartIdx + fetchIterator];

            memCanvasPos++;
            fetchIterator++;

            if((fetchIterator % GLCD_MEASURES_VOLUME_WIDTH) == 0){
                page++;
                memCanvasPos = ((page * GLCD_MEASURES_BASE_WIDTH) + column); 
            }
            Nop();
        }
    }
    
    /*------------------------------------------------------------------------*/
    /* draw total to memory canvas                                           */
    /*------------------------------------------------------------------------*/
    for(volumeStrIdx = 0 ; volumeStrIdx < 4 ; volumeStrIdx++){
        if(aTotal[volumeStrIdx] == 10){
            arrStartIdx = GLCD_UNIT_BLANK_DEF_IDX;  /* blank */
        }else{
            arrStartIdx = (aTotal[volumeStrIdx] * GLCD_TOTAL_UNIT_SIZE);
        }
        
        fetchIterator = 0;
        page = GLCD_MEASURES_TOTAL_STARTPAGE;
        column = GLCD_MEASURES_TOTAL_COL_INDEX + (volumeStrIdx * GLCD_MEASURES_TOTAL_WIDTH);

        memCanvasPos = ((page * GLCD_MEASURES_BASE_WIDTH) + column);       

        while(fetchIterator < GLCD_MEASURES_TOTAL_SIZE){
            memCanvas[memCanvasPos] = NUMSET_TOTAL[arrStartIdx + fetchIterator];

            memCanvasPos++;
            fetchIterator++;

            if((fetchIterator % GLCD_MEASURES_TOTAL_WIDTH) == 0){
                page++;
                memCanvasPos = ((page * GLCD_MEASURES_BASE_WIDTH) + column); 
            }
            Nop();
        }
    }
    
    /*------------------------------------------------------------------------*/
    /* dump memory canvas to LCD                                              */
    /*------------------------------------------------------------------------*/
    page = GLCD_MEASURES_BASE_STARTPAGE;
    column = GLCD_MEASURES_BASE_COL_INDEX;
    
    fetchIterator = 0;
    
    while(gResFlag == OCCUPIED){
        Nop();
    };    
    gResFlag = OCCUPIED;   
    
    GLCDPosition(column, page);    
    
    while(fetchIterator < GLCD_MEASURES_BASE_SIZE){
        GLCDData(memCanvas[fetchIterator]);
        fetchIterator++;
        if((fetchIterator % GLCD_MEASURES_BASE_WIDTH) == 0){
            page++;
            GLCDPosition(column, page);    
        }
        //Nop();
    }
    
    gResFlag = UNOCCUPIED;
}

void GLCDDrawWatch(unsigned char hh, unsigned char mm){
    volatile unsigned char memCanvas[GLCD_WATCH_BASE_SIZE] = {0};
    volatile unsigned int arrStartIdx = 0;
    volatile unsigned int memCanvasPos = 0;
    volatile unsigned int fetchIterator = 0;
    volatile unsigned char page = 0;
    volatile unsigned char column = 0;
    volatile unsigned char hour;
    volatile unsigned char min;
    volatile unsigned char aTimeStr[4] = {0};
    volatile unsigned char iter = 0;
    
    hour = BcdtoDec(hh);
    min = BcdtoDec(mm);
    
    aTimeStr[0] = (hour/10);
    aTimeStr[1] = (hour%10);
    aTimeStr[2] = (min/10);
    aTimeStr[3] = (min%10);
    
    memcpy((void *)memCanvas, WATCH_BASE, sizeof(unsigned char) * GLCD_WATCH_BASE_SIZE);    
    
    /*------------------------------------------------------------------------*/
    /* draw hours and minutes to memory canvas                                */
    /*------------------------------------------------------------------------*/    
    for(iter = 0 ; iter < 4 ; iter++){        
        memCanvasPos = ((page * GLCD_WATCH_BASE_WIDTH) + column);  
        arrStartIdx = (aTimeStr[iter] * GLCD_WATCH_UNIT_SIZE);  

        while(fetchIterator < GLCD_WATCH_UNIT_SIZE){
            memCanvas[memCanvasPos] = NUMSET_WATCH[ (arrStartIdx + fetchIterator) ];
            
            memCanvasPos++;
            fetchIterator++;
            
            if((fetchIterator % GLCD_WATCH_UNIT_WIDTH) == 0){
                page++;
                memCanvasPos = ((page * GLCD_WATCH_BASE_WIDTH) + column);
            }
        }          
        
        if(iter == 1){  /* Skip colon(WATCH_BASE include colon) */
            column += (GLCD_WATCH_UNIT_WIDTH * 2);                
        }else{
            column += GLCD_WATCH_UNIT_WIDTH;    
        }        
        page = 0;
        fetchIterator = 0;
    }    
    
    /*------------------------------------------------------------------------*/
    /* dump memory canvas to LCD                                              */
    /*------------------------------------------------------------------------*/
    page = GLCD_WATCH_UNIT_STARTPAGE;
    column = GLCD_WATCH_10H_INDEX;
    
    fetchIterator = 0;
    
    while(gResFlag == OCCUPIED){
        Nop();
    };    
    gResFlag = OCCUPIED;    
    
    GLCDPosition(column, page);    
    
    while(fetchIterator < GLCD_WATCH_BASE_SIZE){
        GLCDData(memCanvas[fetchIterator]);
        fetchIterator++;
        if((fetchIterator % GLCD_WATCH_BASE_WIDTH) == 0){
            page++;
            GLCDPosition(column, page);    
        }
        //Nop();
    }
    gResFlag = UNOCCUPIED;
}





